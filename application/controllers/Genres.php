<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Genres extends REST_Controller {


    function __construct()
    {

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
           die();
        }


           parent::__construct();

           $this->methods['users_get']['limit'] = 500; 
           $this->methods['users_post']['limit'] = 100; 
           $this->methods['users_delete']['limit'] = 50;
       }

       public function index_post(){

        $post_data = json_decode(file_get_contents('php://input'));
        //debug($post_data ,1);

        $this->load->model('Genero_Model', 'generos');
        $this->load->model('Serie_Model', 'series');

        $genero = $this->generos->get(
            array(
                'genero' => $post_data->genero,
            )
        );

        $series = $this->series->filter(
          array(
            'cd_genero' => $genero->id
          )
        );

        //debug($series ,1);

        $this->response($series,REST_Controller::HTTP_OK);


    } 

    public function index_get(){

        //debug($post_data ,1);

        $this->load->model('Genero_Model', 'generos');
        $this->load->model('Serie_Model', 'series');


        $query = $this->db->select('*')->from('genero')->get()->result();
        //$series = $this->series->filter();

        //debug($query ,1);

        $this->response($query,REST_Controller::HTTP_OK);


    } 

    
}