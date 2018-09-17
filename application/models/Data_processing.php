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
    public function last_profile_value()
    {
      $query_getdefault = $this->db->select('id');
      $query_getdefault = $this->db->where('is_default', '1');
      $query_getdefault = $this->db->get('profiles');
      $row = $query_getdefault->row();
      $default_id = $row->id;
      if ($this->db->table_exists($default_id))
      {
        $sql = "SELECT DATE_FORMAT(`timeStamp`, '%Y-%m-%d-%H:%i:%S') AS `timeMax`, `temperature`, `light`, `moist`, `phvalue` FROM `{$default_id}` WHERE timeStamp=(select max(timeStamp) from `{$default_id}`);";
        $query = $this->db->query($sql);
        return $query;
      }
    }
    public function get_incidents()
    {
      $query_getdefault = $this->db->select('id');
      $query_getdefault = $this->db->where('is_default', '1');
      $query_getdefault = $this->db->get('profiles');
      $row = $query_getdefault->row();
      $default_id = $row->id;
      if ($this->db->table_exists($default_id))
      {
        $this->db->select("DATE_FORMAT(`timeStamp`, '%Y-%m-%d-%H:%i:%S') AS `time`, `temperature`, `moist`, `phvalue`");
        $this->db->order_by('time', 'DESC');
        $this->db->like('is_okay_temp', '0');
        //$this->db->or_like('is_okay_light', '0');
        $this->db->or_like('is_okay_moist', '0');
        $this->db->or_like('is_okay_phvalue', '0');
        $query = $this->db->get($default_id);
        return $query;
      }
    }

    public function check_data()
    {

    }
    public function process_current_sensor_data()
    {

    }
    public function light()
    {

    }
}
