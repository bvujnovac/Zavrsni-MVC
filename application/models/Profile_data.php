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
          echo "Success!";
        }
        else
        {
          echo "Query failed!";
        }

      }
      else {
        //creating the tabel with $id
        #$this->dbforge->create_table($id, TRUE);
        echo "Query failed!";
      }

    }
}
