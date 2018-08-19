<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('get_data');
    $this->load->model('profile_data');
    $this->load->helper('url');
    $this->load->library('session');
  }
  public function index()
  {
    //logging in the user if authenticated.
    $username = strtolower($this->input->post('username', TRUE));
    $password = strtolower($this->input->post('password', TRUE));
    if ($username == 'student' && $password == 'zavrsnirad') {
      $this->session->set_userdata('is_logged_in', TRUE);
      header('Location: /home');
    }
    $is_logged_in = $this->session->is_logged_in;
    //getting min/max timestamp and last sensor values data from the model
    $data['sensors'] = $this->get_data->load_data();
    $values['min'] = $data['sensors']['min'];
    $values['max'] = $data['sensors']['max'];
    //sensor values
    $values['temp'] = $data['sensors']['temp'];
    $values['light'] = $data['sensors']['light'];
    $values['moist'] = $data['sensors']['moist'];
    $values['phvalue'] = $data['sensors']['phvalue'];
    //grab the default and non-defalut profile id's
    $profile = $this->profile_data->get_profile_id();
    $values['id'] = $profile['not_default'];
    $values['id_default'] = $profile['default'];
    //getting the profile selection id sent from the form on home_view
    $profileselect = $this->input->post('profileselect', TRUE);

    //if the profileselect variable is set to a value (chosen from the retreived id values above) go ahead and set that value as a default.
    if ($profileselect)
    {
      $profile = $this->profile_data->set_profile_id($profileselect);
      header('Location: /home');
    }
    //rendering views
    $this->load->view('header_view');
    if ($is_logged_in) {
      $this->load->view('home_view', $values);
    }
    else {
      $this->load->view('login_view');
    }
    $this->load->view('footer_view');
  }
  //default method used to load and prepare the data that is being sent to data_view and then picked up by ajax and used to draw the charts
  public function data()
  {
    $startDate = $this->input->get('time_from', TRUE); //getting date for SQL query, and sanitizing it.
    $endDate = $this->input->get('time_to', TRUE); //getting date for SQL query, and sanitizing it.

    if ($startDate && $endDate)
    {
      $data['values'] = $this->get_data->load_ajax_data($startDate, $endDate);
      $final_data['temperature'] = $data["values"]["temperature"];
      $final_data['light'] = $data["values"]["light"];
      $final_data['moist'] = $data["values"]["moist"];
      $final_data['phvalue'] = $data["values"]["phvalue"];

      $this->load->view('data_view', $final_data);
    }
    else
    {
      header("HTTP/1.1 406 Not Acceptable");
    }
  }
  //method to pass the new sensor data into the appropriate model.
  public function add()
  {
    $id = $this->input->get('id', TRUE); //getting temperature for SQL query, and sanitizing it.
    $temperature = $this->input->get('temperature', TRUE); //getting temperature for SQL query, and sanitizing it.
    $light = $this->input->get('light', TRUE); //getting light for SQL query, and sanitizing it.
    $moist = $this->input->get('moist', TRUE); //getting moist for SQL query, and sanitizing it.
    $phvalue = $this->input->get('phvalue', TRUE); //getting phvalue for SQL query, and sanitizing it.

    if ($id && $temperature && $light && $moist && $phvalue) {
      $this->get_data->add_data($id, $temperature, $light, $moist, $phvalue);
    }
    else {
      //something is missing/not set
      header("HTTP/1.1 406 Not Acceptable");
    }
  }
}
