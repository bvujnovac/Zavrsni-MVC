<?php

class Data_processing extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
    }
    public function check_data(){

    }
    public function process_current_sensor_data(){

    }
    public function light(){

    }
}
