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
          'table_open'            => '<table border="0" cellpadding="4" cellspacing="0">',

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

        //$values['tables'] = $this->table->set_template($template);
        $values['tables'] = $this->table->generate($profiles);

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
