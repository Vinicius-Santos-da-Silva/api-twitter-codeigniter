<?php
class Comentario_Model extends Super_Model {

    public function __construct(){

        parent::__construct();
        $this->table        = 'comentario';
        $this->primary_key  = 'id';

    }  
}