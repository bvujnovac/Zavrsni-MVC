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
    }

    public function index()
    {
        $data['sensors'] = $this->get_data->load_data();
        $values['max'] = $data['sensors']['max'];

        $this->load->view('header_view');
        $this->load->view('profile_view', $values);
        $this->load->view('footer_view');
    }

    public function add()
    {

    }
    public function update()
    {

    }
}
