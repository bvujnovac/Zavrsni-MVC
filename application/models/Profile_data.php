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
    }

    public function existing_profiles()
    {

    }

    public function new_profiles()
    {

    }
}