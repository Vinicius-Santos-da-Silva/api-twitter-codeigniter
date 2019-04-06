<?php
class Status_Model extends Super_Model {

    public function __construct(){

        parent::__construct();
        $this->table        = 'status';
        $this->primary_key  = 'id';

    }  
}