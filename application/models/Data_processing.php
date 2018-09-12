<?php

class Data_processing extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
    }
    //grabbing existing profiles data from profiles table
    public function existing_profiles()
    {
      if ($this->db->table_exists('profiles'))
      {
        $this->db->select('id, temperatureopt, temperaturemax, lighthours, moisture, phvaluemin, phvaluemax');
        $this->db->where('is_default', '1');
        $query = $this->db->get('profiles');
        return $query;
      }
    }
    public function check_data(){

    }
    public function process_current_sensor_data(){

    }
    public function light(){

    }
}
