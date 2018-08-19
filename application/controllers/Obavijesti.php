<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obavijesti extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->model('get_data');
        $this->load->model('profile_data');
        $this->load->helper('url');
        $this->load->library('table');
    }

    public function index()
    {
        $data['sensors'] = $this->get_data->load_data();
        $values['max'] = $data['sensors']['max'];
        $profiles = $this->profile_data->existing_profiles();

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

        $values['tables'] = $this->table->set_heading('Profil', 'Temperaturni opt.', 'Temperaturni maks.', 'Osvjetljenje (h)', 'Vlaga', 'Ph min.', 'Ph maks.', 'Zadani profil');
        $values['tables'] = $this->table->set_template($template);
        $values['tables'] = $this->table->generate($profiles);

        $profile = $this->profile_data->get_profile_id();
        $values['id'] = $profile['not_default'];
        $values['id_default'] = $profile['default'];

        $profiledelete = $this->input->post('profiledelete', TRUE);
        if ($profiledelete)
        {
          $this->profile_data->delete_profile_id($profiledelete);
          header('Location: /profili');
        }

        $this->load->view('header_view');
        $this->load->view('obavijesti_view', $values);
        $this->load->view('footer_view');
    }

}
