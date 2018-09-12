<?php
/**
 * Created by PhpStorm.
 * User: beni
 * Date: 11.04.18.
 * Time: 12:38
 */
class Profile_data extends CI_Model {
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
        $query = $this->db->get('profiles');
        return $query;
      }
    }
    //method to add new proffile passed from the controller.
    public function new_profile($id, $temperatureopt, $temperaturemax, $lighthours, $moisture, $phvaluemin, $phvaluemax)
    {
      $id = $id;
      $temperatureopt = $temperatureopt;
      $temperaturemax = $temperaturemax;
      $lighthours = $lighthours;
      $moisture = $moisture;
      $phvaluemin = $phvaluemin;
      $phvaluemax = $phvaluemax;
      $ok = 'OK';

      if ($this->db->table_exists('profiles'))
      {
        $addtoTable = array('id' => $id, 'temperatureopt' => $temperatureopt,'temperaturemax' => $temperaturemax,'lighthours' => $lighthours,'moisture' => $moisture,'phvaluemin' => $phvaluemin,'phvaluemax' => $phvaluemax);
        $this->db->insert('profiles', $addtoTable);

        $sql = "CREATE TABLE `bvujnova_zavrsni`.`{$id}` ( `timeStamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `temperature` FLOAT NULL DEFAULT NULL , `light` INT NULL DEFAULT NULL , `moist` INT NULL DEFAULT NULL , `phvalue` INT NULL DEFAULT NULL , PRIMARY KEY (`timeStamp`)) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
        //custom sql to create the new profile id separate table.
        $this->db->query($sql);
      }
    }
    // getting the default/non-default profile id and passing it to the controller.
    public function get_profile_id ()
    {
      if ($this->db->table_exists('profiles'))
      {
        $query = $this->db->select('id');
        $query = $this->db->where('is_default', '0');
        $query = $this->db->get('profiles');

        $query1 = $this->db->select('id');
        $query1 = $this->db->where('is_default', '1');
        $query1 = $this->db->get('profiles');

        $profileValueArray = array();
        $profileValuenot = array();
        $profileValueyes = array();

        foreach ($query->result() as $row)
        {
          $profileValuenot[] = $row->id;
        }
        foreach ($query1->result() as $row)
        {
          $profileValueyes[] = $row->id;
        }
        $profileValueArray = array_push_assoc($profileValueArray,'not_default', $profileValuenot);
        $profileValueArray = array_push_assoc($profileValueArray,'default', $profileValueyes);

        return $profileValueArray;
      }
    }
    //unsetting the current profile as default and setting the provided profile id as a default profile.
    public function set_profile_id ($profileselect)
    {
      $profileselect = $profileselect;

      if ($this->db->table_exists('profiles'))
      {
        //unseting the current default profile
        $query_getunset = $this->db->select('id');
        $query_getunset = $this->db->where('is_default', '1');
        $query_getunset = $this->db->get('profiles');
        $row = $query_getunset->row();
        $default_id = $row->id;

        $data_unset = array(
          'is_default' => '0'
        );
        $query_unset = $this->db->where('id', $default_id);
        $query_unset = $this->db->update('profiles', $data_unset);
        //setting the new default profiles
        $data_set = array(
          'is_default' => '1'
        );
        $query_set = $this->db->where('id', $profileselect);
        $query_set = $this->db->update('profiles', $data_set);
      }
    }
    //deleting the provided profile id and it's data table.
    public function delete_profile_id($profiledelete)
    {
      $this->db->where('id', $profiledelete);
      $this->db->delete('profiles');
      $this->dbforge->drop_table($profiledelete);
    }
}
