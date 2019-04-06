<?php
class Genero_Model extends Super_Model {

    public function __construct(){

        parent::__construct();
        $this->table        = 'genero';
        $this->primary_key  = 'id';

    }  


}