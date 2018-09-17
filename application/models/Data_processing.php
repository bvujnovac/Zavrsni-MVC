<?php

class Data_processing extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
    }
    function array_push_assoc($array, $key, $value){
      $array[$key] = $value;
      return $array;
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
        $this->db->limit(12);
        $query = $this->db->get($default_id);
        return $query;
      }
    }

    public function check_data()
    {
      $is_okayArray = array();

      $query_getdefault = $this->db->select('id');
      $query_getdefault = $this->db->where('is_default', '1');
      $query_getdefault = $this->db->get('profiles');
      $row = $query_getdefault->row();
      $default_id = $row->id;

      if($this->db->table_exists($default_id))
      {
        $this->db->select('is_okay_temp, is_okay_light, is_okay_moist, is_okay_phvalue');
        $this->db->order_by('timeStamp', 'DESC');
        $this->db->limit(1);
        //$this->db->select_max('timeStamp');
        $query = $this->db->get($default_id);

        foreach ($query->result() as $row)
        {
          $tempOk = $row->is_okay_temp;
          $lightOk = $row->is_okay_light;
          $moistOk = $row->is_okay_moist;
          $phvalueOk = $row->is_okay_phvalue;
        }
      }
      $is_okayArray = array_push_assoc($is_okayArray,'tempOk', $tempOk);
      $is_okayArray = array_push_assoc($is_okayArray,'lightOk', $lightOk);
      $is_okayArray = array_push_assoc($is_okayArray,'moistOk', $moistOk);
      $is_okayArray = array_push_assoc($is_okayArray,'phvalueOk', $phvalueOk);

      return $is_okayArray;
    }
    public function process_current_sensor_data()
    {

    }
    public function light()
    {

    }
}
