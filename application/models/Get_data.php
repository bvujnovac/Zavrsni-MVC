<?php
/**
* Created by PhpStorm.
* User: beni
* Date: 04.04.18.
* Time: 18:28
*/
class Get_data extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  //method to retrieve data from database and format it.
  public function load_data()
  {

    //grabbing the default profile id from 'profiles' table
    $query_getdefault = $this->db->select('id');
    $query_getdefault = $this->db->where('is_default', '1');
    $query_getdefault = $this->db->get('profiles');
    $row = $query_getdefault->row();
    $default_id = $row->id;

    //function to be later used when creating associative array's
    function array_push_assoc($array, $key, $value){
      $array[$key] = $value;
      return $array;
    }

    $querycheck = $this->db->get($default_id);

    if($querycheck->num_rows() > 0) {     //checking if returned query has any rows (not empty table), fixes bug on selected profile containing no data yet.

      $sqlmintime = "SELECT DATE_FORMAT(`timeStamp`, '%Y-%m-%d') AS `timeMin` FROM `{$default_id}` WHERE timeStamp=(select min(timeStamp) from `{$default_id}`)";
      $sqlmaxtime = "SELECT DATE_FORMAT(`timeStamp`, '%Y-%m-%d') AS `timeMax` FROM `{$default_id}` WHERE timeStamp=(select max(timeStamp) from `{$default_id}`)";
      $sqllasttemp = "SELECT `temperature` AS `temp` FROM `{$default_id}` WHERE timeStamp=(select max(timeStamp) from `{$default_id}`)";
      $sqllastlight = "SELECT `light` AS `light` FROM `{$default_id}` WHERE timeStamp=(select max(timeStamp) from `{$default_id}`)";
      $sqllastmoist = "SELECT `moist` AS `moist` FROM `{$default_id}` WHERE timeStamp=(select max(timeStamp) from `{$default_id}`)";
      $sqllastphvalue = "SELECT `phvalue` AS `phvalue` FROM `{$default_id}` WHERE timeStamp=(select max(timeStamp) from `{$default_id}`)";

      $minmaxArray = array();

      //min and max time stamp
      $querysqlmintime = $this->db->query($sqlmintime);
      $querysqlmaxtime = $this->db->query($sqlmaxtime);
      //per sensor query's
      $querysqllasttemp = $this->db->query($sqllasttemp);
      $querysqllastlight = $this->db->query($sqllastlight);
      $querysqllastmoist = $this->db->query($sqllastmoist);
      $querysqllastphvalue = $this->db->query($sqllastphvalue);


      //begin..set values per query from row to variable.
      foreach ($querysqlmintime->result() as $row)
      {
        $min = $row->timeMin;

      }
      foreach ($querysqlmaxtime->result() as $row)
      {
        $max = $row->timeMax;

      }
      foreach ($querysqllasttemp->result() as $row)
      {
        $temp = $row->temp;

      }
      foreach ($querysqllastlight->result() as $row)
      {
        $light = $row->light;

      }
      foreach ($querysqllastmoist->result() as $row)
      {
        $moist = $row->moist;

      }
      foreach ($querysqllastphvalue->result() as $row)
      {
        $phvalue = $row->phvalue;

      }
      //end..set values per query from row to variable.

      //getting minimum and maximum time stamp value
      $minmaxArray = array_push_assoc($minmaxArray,'min', $min);
      $minmaxArray = array_push_assoc($minmaxArray,'max', $max);
      // getting sensor values for the maximum time stamp (last entry)
      $minmaxArray = array_push_assoc($minmaxArray,'temp', $temp);
      $minmaxArray = array_push_assoc($minmaxArray,'light', $light);
      $minmaxArray = array_push_assoc($minmaxArray,'moist', $moist);
      $minmaxArray = array_push_assoc($minmaxArray,'phvalue', $phvalue);

      //returning the finall array, name stuck becase originally it was only used for min and max time stamp values
      return $minmaxArray;

    }
    else{
        //echo "empty table" . " " . $default_id;
        }
  }

  //preparing data for ajax reqeust
  public function load_ajax_data($start, $end)
  {

    //data passed from home controller
    $startDate = $start; //date requestd on home view
    $endDate = $end; //date requestd on home view

    //grabbing the default profile id from 'profiles' table
    $query_getdefault = $this->db->select('id');
    $query_getdefault = $this->db->where('is_default', '1');
    $query_getdefault = $this->db->get('profiles');
    $row = $query_getdefault->row();
    $default_id = $row->id;

    //custom sql query to get the specific values from default set profile corresponding table
    $sql = "SELECT `timeStamp` AS `time`, `temperature`, `light`, `moist`, `phvalue` FROM `{$default_id}` WHERE `timeStamp` BETWEEN '{$startDate}' AND '{$endDate}' ORDER BY `timeStamp` ASC";

    //preparring array's
    $jsonArrayTemperature = array();
    $jsonArrayLight = array();
    $jsonArrayMoist = array();
    $jsonArrayPhvalue = array();
    $finalArray = array();

    //grabbing data per aboce custom sql query
    $query = $this->db->query($sql);

    //sorting the grabbed data
    foreach ($query->result() as $row)
    {
      $jsonArrayItemTemperature = array();
      $jsonArrayItemLight = array();
      $jsonArrayItemMoist = array();
      $jsonArrayItemPhvalue = array();
      $jsonArrayItemTemperature['label'] = $row->time;
      $jsonArrayItemTemperature['value'] = $row->temperature;
      $jsonArrayItemLight['label'] = $row->time;
      $jsonArrayItemLight['value'] = $row->light;
      $jsonArrayItemMoist['label'] = $row->time;
      $jsonArrayItemMoist['value'] = $row->moist;
      $jsonArrayItemPhvalue['label'] = $row->time;
      $jsonArrayItemPhvalue['value'] = $row->phvalue;
      //append the above created arrays into the main array.
      array_push($jsonArrayTemperature, $jsonArrayItemTemperature);
      array_push($jsonArrayLight, $jsonArrayItemLight);
      array_push($jsonArrayMoist, $jsonArrayItemMoist);
      array_push($jsonArrayPhvalue, $jsonArrayItemPhvalue);
    }
    //function to push array into an associative array
    function array_push_assoc($array, $key, $value){
      $array[$key] = $value;
      return $array;
    }

    //creating an associative array's containing per sensor values in array
    $finalArray = array_push_assoc($finalArray,'temperature', $jsonArrayTemperature);
    $finalArray = array_push_assoc($finalArray,'light', $jsonArrayLight);
    $finalArray = array_push_assoc($finalArray,'moist', $jsonArrayMoist);
    $finalArray = array_push_assoc($finalArray,'phvalue', $jsonArrayPhvalue);

    //returning associative array to the controller that called the method.
    return $finalArray;
  }

  //method to add new sensor data into the appropriate profile-table.
  public function add_data($id, $temperature, $light, $moist, $phvalue)
  {
    $id = $id;
    $temperature = $temperature;
    $light = $light;
    $moist = $moist;
    $phvalue = $phvalue;

    if ($this->db->table_exists($id)) //if table with given id exists proceed with adding the data.
    {
      $addData = array('temperature' => $temperature,'light' => $light,'moist' => $moist,'phvalue' => $phvalue);
      $this->db->insert($id, $addData);
    }
  }
}
