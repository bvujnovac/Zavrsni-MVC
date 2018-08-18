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

    public function existing_profiles()
    {
      if ($this->db->table_exists('profiles'))
      {
        $query = $this->db->get('profiles');
        return $query;
      }
      else {
        // code...else
      }

    }

    public function new_profile($id, $temperatureopt, $temperaturemax, $lighthours, $moisture, $phvaluemin, $phvaluemax)
    {
      $id = $id;
      $temperatureopt = $temperatureopt;
      $temperaturemax = $temperaturemax;
      $lighthours = $lighthours;
      $moisture = $moisture;
      $phvaluemin = $phvaluemin;
      $phvaluemax = $phvaluemax;

      if ($this->db->table_exists('profiles'))
      {
        $addtoTable = array('id' => $id, 'temperatureopt' => $temperatureopt,'temperaturemax' => $temperaturemax,'lighthours' => $lighthours,'moisture' => $moisture,'phvaluemin' => $phvaluemin,'phvaluemax' => $phvaluemax);
        $this->db->insert('profiles', $addtoTable);

        /*$fields = array(
          'timeStamp' => array(
            'type' => 'TIMESTAMP',
            'null' => FALSE,
            'default' => 'CURRENT_TIMESTAMP',
          ),
          'temperature' => array(
            'type' => 'FLOAT',
            'null' => FALSE,
          ),
          'light' => array(
            'type' => 'INT',
            'null' => FALSE,
          ),
          'moist' => array(
            'type' => 'INT',
            'null' => FALSE,
          ),
          'phvalue' => array(
            'type' => 'INT',
            'null' => FALSE,
          ),
        );*/

        /*$this->dbforge->add_field($fields);
        $this->dbforge->add_key('timeStamp', TRUE);
        // gives PRIMARY KEY (timeStamp)
        $this->dbforge->create_table($id, TRUE);*/
        $sql = "CREATE TABLE `bvujnova_zavrsni`.`{$id}` ( `timeStamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `temperature` FLOAT NULL DEFAULT NULL , `light` INT NULL DEFAULT NULL , `moist` INT NULL DEFAULT NULL , `phvalue` INT NULL DEFAULT NULL , PRIMARY KEY (`timeStamp`)) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";

        if ($this->db->query($sql))
        {
          //echo "Success!";
          header('Location: /profili');
        }
        else
        {
          //echo "Query failed!";
        }

      }
      else {
        //creating the tabel with $id
        #$this->dbforge->create_table($id, TRUE);
        echo "Query failed!";
      }

    }

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
      else {
        // code...else
      }
    }

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
        $query_unset = $this->db->where('id', $profileselect);
        $query_unset = $this->db->update('profiles', $data_set);
//get not default profile
        $query = $this->db->select('id');
        $query = $this->db->where('is_default', '0');
        $query = $this->db->get('profiles');
//get default profile
        $query1 = $this->db->select('id');
        $query1 = $this->db->where('is_default', '1');
        $query1 = $this->db->get('profiles');
//arrays
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
      else {
        // code...else
      }
    }

    public function delete_profile_id($profiledelete)
    {
      $this->db->where('id', $profiledelete);
      $this->db->delete('profiles');
      $this->dbforge->drop_table($profiledelete);
    }
}
