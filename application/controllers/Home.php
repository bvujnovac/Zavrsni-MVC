<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('get_data');
    $this->load->helper('url');
  }
  public function index()
  {
    //getting data from the model
    $data['sensors'] = $this->get_data->load_data();
    $values['min'] = $data['sensors']['min'];
    $values['max'] = $data['sensors']['max'];

    //rendering views
    $this->load->view('header_view');
    $this->load->view('home_view', $values);
    $this->load->view('footer_view');
  }
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
      //else
      header("HTTP/1.1 406 Not Acceptable");
    }
  }
}
