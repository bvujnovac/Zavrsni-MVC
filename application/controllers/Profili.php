<?php
/**
 * Created by PhpStorm.
 * User: beni
 * Date: 11.04.18.
 * Time: 12:35
 */
class Profili extends CI_Controller {
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
        $this->load->view('profile_view', $values);
        $this->load->view('footer_view');
    }

    public function add()
    {
      #$str = strtolower($str);
      $id = strtolower($this->input->get('profilename', TRUE)); //getting temperature for SQL query, and sanitizing it.
      $temperatureopt = strtolower($this->input->get('temperatureopt', TRUE)); //getting temperature for SQL query, and sanitizing it.
      $temperaturemax = strtolower($this->input->get('temperaturemax', TRUE)); //getting temperature for SQL query, and sanitizing it.
      $lighthours = strtolower($this->input->get('lighthours', TRUE)); //getting light for SQL query, and sanitizing it.
      $moisture = strtolower($this->input->get('moisture', TRUE)); //getting moist for SQL query, and sanitizing it.
      $phvaluemin = strtolower($this->input->get('phvaluemin', TRUE)); //getting phvalue for SQL query, and sanitizing it.
      $phvaluemax = strtolower($this->input->get('phvaluemax', TRUE)); //getting phvalue for SQL query, and sanitizing it.

      if ($id && $temperatureopt && $temperaturemax && $lighthours && $moisture && $phvaluemin && $phvaluemax) {
        $this->profile_data->new_profile($id, $temperatureopt, $temperaturemax, $lighthours, $moisture, $phvaluemin, $phvaluemax);
      }
      else {
        header("HTTP/1.1 406 Not Acceptable");
      }
    }
    public function update()
    {

    }
}
