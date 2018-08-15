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
    $sql1 = "SELECT DATE_FORMAT(`timeStamp`, '%Y-%m-%d') AS `timeMin` FROM `datalog` WHERE timeStamp=(select min(timeStamp) from datalog)";
    $sql2 = "SELECT DATE_FORMAT(`timeStamp`, '%Y-%m-%d') AS `timeMax` FROM `datalog` WHERE timeStamp=(select max(timeStamp) from datalog)";

    $minmaxArray = array();

    $query1 = $this->db->query($sql1);
    $query2 = $this->db->query($sql2);

    foreach ($query1->result() as $row)
    {
      $min = $row->timeMin;

    }

    foreach ($query2->result() as $row)
    {
      $max = $row->timeMax;

    }

    function array_push_assoc($array, $key, $value){
      $array[$key] = $value;
      return $array;
    }

    $minmaxArray = array_push_assoc($minmaxArray,'min', $min);
    $minmaxArray = array_push_assoc($minmaxArray,'max', $max);

    return $minmaxArray;
  }


  public function load_ajax_data($start, $end)
  {

    $startDate = $start; //fixed data for now
    $endDate = $end; //fixed date for now.

    $sql = "SELECT `timeStamp` AS `time`, `temperature`, `light`, `moist`, `phvalue` FROM `datalog` WHERE `timeStamp` BETWEEN '{$startDate}' AND '{$endDate}' ORDER BY `timeStamp` ASC";

    //$query= $this->db->get('datalog');

    $jsonArrayTemperature = array();
    $jsonArrayLight = array();
    $jsonArrayMoist = array();
    $jsonArrayPhvalue = array();
    $finalArray = array();

    $query = $this->db->query($sql);

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
    //function to create
    function array_push_assoc($array, $key, $value){
      $array[$key] = $value;
      return $array;
    }

    $finalArray = array_push_assoc($finalArray,'temperature', $jsonArrayTemperature);
    $finalArray = array_push_assoc($finalArray,'light', $jsonArrayLight);
    $finalArray = array_push_assoc($finalArray,'moist', $jsonArrayMoist);
    $finalArray = array_push_assoc($finalArray,'phvalue', $jsonArrayPhvalue);

    return $finalArray;
  }

  public function add_data($id, $temperature, $light, $moist, $phvalue)
  {
    $id = $id;
    $temperature = $temperature;
    $light = $light;
    $moist = $moist;
    $phvalue = $phvalue;

    if ($this->db->table_exists($id))
    {
      $addData = array('temperature' => $temperature,'light' => $light,'moist' => $moist,'phvalue' => $phvalue);
      $this->db->insert($id, $addData);
    }
    else {
      // table does not exist.
    }

  }
}
