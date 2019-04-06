<?php
class Users extends Super_Model {

    public function __construct(){

        parent::__construct();
        $this->table        = 'users';
        $this->primary_key  = 'id';

    }  
}