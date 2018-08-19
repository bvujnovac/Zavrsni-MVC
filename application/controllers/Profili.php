<?php
/**
 * Created by PhpStorm.
 * User: beni
 * Date: 11.04.18.
 * Time: 12:35
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Profili extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->model('get_data');
        $this->load->model('profile_data');
        $this->load->helper('url');
        $this->load->library('table');
        $this->load->library('session');
    }
    public function index()
    {
        $is_logged_in = $this->session->is_logged_in;
        //getting max time stamp value to maintain the profile view look simillar to the home view
        $data = $this->get_data->load_data();
        $values['max'] = $data['max'];
        //getting the existing profiles data from the appropriate table
        $profiles = $this->profile_data->existing_profiles();
        //template for table construction in profile_view
        $template = array(
          'table_open'            => '<table class="table table-condensed">',

          'thead_open'            => '<thead>',
          'thead_close'           => '</thead>',

          'heading_row_start'     => '<tr>',
          'heading_row_end'       => '</tr>',
          'heading_cell_start'    => '<th>',
          'heading_cell_end'      => '</th>',

          'tbody_open'            => '<tbody>',
          'tbody_close'           => '</tbody>',

          'row_start'             => '<tr>',
          'row_end'               => '</tr>',
          'cell_start'            => '<td>',
          'cell_end'              => '</td>',

          'row_alt_start'         => '<tr>',
          'row_alt_end'           => '</tr>',
          'cell_alt_start'        => '<td>',
          'cell_alt_end'          => '</td>',

          'table_close'           => '</table>'
        );
        //setting the heading and generating the data table
        $values['tables'] = $this->table->set_heading('Profil', 'Temperaturni opt.', 'Temperaturni maks.', 'Osvjetljenje (h)', 'Vlaga', 'Ph min.', 'Ph maks.', 'Zadani profil');
        $values['tables'] = $this->table->set_template($template);
        $values['tables'] = $this->table->generate($profiles);
        //this is here as a requirement for the drop-down menu to delete the profile which is not needed.
        //getting the default and non-default profile id's
        $profile = $this->profile_data->get_profile_id();
        $values['id'] = $profile['not_default'];
        $values['id_default'] = $profile['default'];
        //if there is input from the profiledelete form, get it and sanatize it
        $profiledelete = $this->input->post('profiledelete', TRUE);
        if ($profiledelete) //if profiledelete is set
        {
          //delete the profile and it's table and return to the profile_view
          $this->profile_data->delete_profile_id($profiledelete);
          header('Location: /profili');
        }
        $this->load->view('header_view');
        if ($is_logged_in) {
        $this->load->view('profile_view', $values);
        }
        else {
          header('Location: /home');
        }
        $this->load->view('footer_view');
    }
    //method to add the new profile
    public function add()
    {
      //geting the data from the submited form from profile_view
      $id = strtolower($this->input->get('profilename', TRUE)); //getting temperature for SQL query, and sanitizing it.
      $temperatureopt = strtolower($this->input->get('temperatureopt', TRUE)); //getting temperature for SQL query, and sanitizing it.
      $temperaturemax = strtolower($this->input->get('temperaturemax', TRUE)); //getting temperature for SQL query, and sanitizing it.
      $lighthours = strtolower($this->input->get('lighthours', TRUE)); //getting light for SQL query, and sanitizing it.
      $moisture = strtolower($this->input->get('moisture', TRUE)); //getting moist for SQL query, and sanitizing it.
      $phvaluemin = strtolower($this->input->get('phvaluemin', TRUE)); //getting phvalue for SQL query, and sanitizing it.
      $phvaluemax = strtolower($this->input->get('phvaluemax', TRUE)); //getting phvalue for SQL query, and sanitizing it.
      //if all necessary fields are set go ahead and create a new profile.
      if ($id && $temperatureopt && $temperaturemax && $lighthours && $moisture && $phvaluemin && $phvaluemax) {
        $this->profile_data->new_profile($id, $temperatureopt, $temperaturemax, $lighthours, $moisture, $phvaluemin, $phvaluemax);
        header('Location: /profili');
      }
      else {
        //something is missing/not set
        header("HTTP/1.1 406 Not Acceptable");
      }
    }
}
