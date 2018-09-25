<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obavijesti extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->model('get_data');
        $this->load->model('profile_data');
        $this->load->model('data_processing');
        $this->load->helper('url');
        $this->load->library('table');
        $this->load->library('session');
    }

    public function index()
    {
        $is_logged_in = $this->session->is_logged_in;
        $data['sensors'] = $this->get_data->load_data();
        $values['max'] = $data['sensors']['max'];
        $profiles = $this->data_processing->existing_profiles();
        //$ids = $this->data_processing->last_profile_value();
        $ids = $this->data_processing->get_incidents();
        // show grade
        $incidents = $this->data_processing->process_current_sensor_data();
        $values['tempOk'] = $incidents['tempOk'];
        $values['lightOk'] = $incidents['lightOk'];
        $values['moistOk'] = $incidents['moistOk'];
        $values['phvalueOk'] = $incidents['phvalueOk'];
        $values['phvalueOut'] = $incidents['phvalueOut'];
        //light values
        $lights = $this->data_processing->light();

        $profile = $this->profile_data->get_profile_id();
        $values['id'] = $profile['not_default'];
        $values['id_default'] = $profile['default'];

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

        $values['tables'] = $this->table->set_heading('Profil', 'Temperaturni opt.', 'Temperaturni maks.', 'Osvjetljenje (h)', 'Vlaga', 'pH min.', 'pH maks.');
        $values['tables'] = $this->table->set_template($template);
        $values['tables'] = $this->table->generate($profiles);

        $values['incidenti'] = $this->table->set_heading('Vrijeme', 'Temperatura', 'Vlaga', 'pH vrijednost');
        $values['incidenti'] = $this->table->set_template($template);
        $values['incidenti'] = $this->table->generate($ids);

        $variable = $profile['default'][0];

        $values['lights'] = $this->table->set_heading('Datum', "Broj sati za: "."$variable");
        $values['lights'] = $this->table->set_template($template);
        $values['lights'] = $this->table->generate($lights);


        //getting the profile selection id sent from the form on obavijesti_view
        $profileselect = $this->input->post('profileselect', TRUE);

        //if the profileselect variable is set to a value (chosen from the retreived id values above) go ahead and set that value as a default.
        if ($profileselect)
        {
          $profile = $this->profile_data->set_profile_id($profileselect);
          header('Location: /obavijesti');
        }

        $this->load->view('header_view');
        if ($is_logged_in) {
        $this->load->view('obavijesti_view', $values);
        }
        else {
          header('Location: /home');
        }
        $this->load->view('footer_view');
    }
    public function domanual()
    {
      $this->data_processing->manual_light();
    }

}
