<?php
class Serie_Model extends Super_Model {

    public function __construct(){

        parent::__construct();
        $this->table        = 'serie';
        $this->primary_key  = 'id';

    }  


}