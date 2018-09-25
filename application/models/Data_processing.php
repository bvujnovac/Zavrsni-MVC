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
        $this->db->limit(24);
        $query = $this->db->get($default_id);
        return $query;
      }
    }

    public function process_current_sensor_data()
    {
      $is_okayArray = array();

      $query_getdefault = $this->db->select('id');
      $query_getdefault = $this->db->where('is_default', '1');
      $query_getdefault = $this->db->get('profiles');
      $row = $query_getdefault->row();
      $default_id = $row->id;

      if($this->db->table_exists($default_id))
      {
        $this->db->select('phvalue, is_okay_temp, is_okay_light, is_okay_moist, is_okay_phvalue');
        $this->db->order_by('timeStamp', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($default_id);

        foreach ($query->result() as $row)
        {
          $tempOk = $row->is_okay_temp;
          $lightOk = $row->is_okay_light;
          $moistOk = $row->is_okay_moist;
          $phvalueOk = $row->is_okay_phvalue;
          $phvalueOut = $row->phvalue;
        }
      }

      #suppresing errors the dirty way
        @$is_okayArray = array_push_assoc($is_okayArray,'tempOk', $tempOk);
        @$is_okayArray = array_push_assoc($is_okayArray,'lightOk', $lightOk);
        @$is_okayArray = array_push_assoc($is_okayArray,'moistOk', $moistOk);
        @$is_okayArray = array_push_assoc($is_okayArray,'phvalueOk', $phvalueOk);
        @$is_okayArray = array_push_assoc($is_okayArray,'phvalueOut', $phvalueOut);

      return $is_okayArray;
    }
    public function light()
    {
      $query_getdefault = $this->db->select('id');
      $query_getdefault = $this->db->where('is_default', '1');
      $query_getdefault = $this->db->get('profiles');
      $row = $query_getdefault->row();
      $default_id = $row->id;
      if ($this->db->table_exists($default_id))
      {
        $this->db->select("date, $default_id");
        $this->db->order_by('date', 'DESC');
        //$this->db->where('date is NOT NULL', NULL, FALSE);
        $this->db->where("$default_id is NOT NULL", NULL, FALSE);
        $query = $this->db->get('lighthours');
        return $query;
      }

    }
    public function manual_light()
    {
      $query_getdefault = $this->db->select('id');
      $query_getdefault = $this->db->where('is_default', '1');
      $query_getdefault = $this->db->get('profiles');
      $row = $query_getdefault->row();
      $default_id = $row->id;
      if ($this->db->table_exists($default_id))
      {
        $datestring = '%Y-%m-%d';
        $time = time();
        $timeString = mdate($datestring, $time);

        $date = "2018-09-25";

        $this->db->select('is_okay_light');
        $this->db->where('is_okay_light', '1');
        $this->db->from($default_id);
        $this->db->where('DATE(timeStamp)', $timeString);
        $lightNumber = $this->db->count_all_results();

        $lighthours = $lightNumber / 2;

        if ($this->db->table_exists('lighthours'))
        {
        $this->db->where('date', $timeString);
        $q = $this->db->get('lighthours');
        #var_dump($q);
        if ($q->num_rows() > 0) {
        $data = array(
          $default_id => $lighthours
        );

        $this->db->where('date', $timeString);
        $this->db->update('lighthours', $data);
        }
        else {
          $this->db->set('date', $timeString);
          $this->db->insert('lighthours');
          //echo $this->db->last_query();

        $this->db->where('date', $timeString);
        $q1 = $this->db->get('lighthours');
        //var_dump($q1);
        if ($q1->num_rows() > 0) {
        $data = array(
          $default_id => $lighthours
        );

        $this->db->where('date', $timeString);
        $this->db->update('lighthours', $data);
        }
        }
        }
      }
    }
}
