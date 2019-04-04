<?php
class Super_Model extends CI_Model {

    var $table          = null;
    var $primary_key    = 'id';

    public function __construct(){

        parent::__construct();
        $this->load->database();

    }

    public function get($where = null){

        if(!$where){
            throw new Exception('Nenhuma condição informada para a clausula "where"');
        }

        if(is_array($where)){

            foreach($where as $field => $value){

                if (trim(strtoupper($value)) != 'IS NULL' 
                and trim(strtoupper($value)) != 'IS NOT NULL'){
                    $this->db->where($field, $value);
                } else {
                    $this->db->where($field.' '.$value);
                }

            }

            $item = $this->db->get($this->table);

        } else {

            $item = $this->db->get_where($this->table, array(
                    $this->primary_key => $where
                )
            );

        }

        $this->db->reset_query();

        if($item->num_rows() == 1){
            if(method_exists($this, 'normalize')){
                return $this->normalize($item->row());
            } else {
                return $item->row();    
            }
        }else if($item->num_rows() == 0){
            return false;
        } else {
            throw new Exception('Mais de um registro foi retornado. Revise sua condição. ['.implode(";",$where).']');
        }

    }

    public function filter($where = null, $limit = 0, $offset = 0, $orderby = null){

        if(!$where){
            throw new Exception('Nenhuma condição informada para a clausula "where"');
        }

        if($limit){
            $this->db->limit($limit, $offset);
        }

        if($orderby){
            $this->db->order_by($orderby);
        }

        foreach($where as $field => $value){
            if(strpos(strtoupper($value), 'LIKE') !== false){
                $value = trim(str_replace(array('LIKE(', 'LIKE (', ')'), '', strtoupper($value)));
                $this->db->like($field, $value);
            } else {
                if (trim(strtoupper($value)) != 'IS NULL' 
                    and trim(strtoupper($value)) != 'IS NOT NULL'){
                    $this->db->where($field, $value);
                } else {
                    $this->db->where($field.' '.$value);
                }
            }

        }

        $itens = $this->db->get($this->table);

        $this->db->reset_query();  

        if($itens->num_rows() > 0){

            if(method_exists($this, 'normalize')){
                $normalized_itens = array();

                foreach($itens->result() as $item){
                    $normalized_itens[] = $this->normalize($item);
                }

                return (object)$normalized_itens;

            } else {

                return $itens->result();

            }
        }

        return array();
        
    }

    public function all($limit = 0, $offset = 0, $orderby = null){

        if($limit){
            $this->db->limit($limit, $offset);
        }

        if($orderby){
            $this->db->order_by($orderby);
        }

        $usuarios = $this->db->get($this->table);

        $this->db->reset_query();

        if($usuarios->num_rows() > 0){
            return $usuarios->result();
        }

        return false;

    }

    public function add($data = null){

        if(!$data){
            throw new Exception('Dados de inserção não informados');
        }

        if(is_array($data)){

            if($this->db->insert($this->table, $data)){

                return $this->db->insert_id();

            }


        }

        return false;

    }

    public function update($data = null, $where=null){

        if(!$data){
            throw new Exception('Dados de inserção não informados');
        }

        if(is_array($data)){

            // Retira as normalizações dos dados
            foreach($data as $field_name => $field_value){
                if(strpos($field_name, '_normalized')){
                    unset($data[$field_name]);
                }
            }

            if(!$where){

                if($this->db->replace($this->table, $data)){
                    return $data;
                }

            } else {

                if(is_array($where)){

                    foreach($where as $field => $value){

                        if ($value != 'IS NULL' or $value != 'IS NOT NULL'){
                            $this->db->where($field, $value);
                        } else {
                            $this->db->where($field.' '.$value);
                        }

                    }

                    return $this->db->update($this->table, $data);

                } else {

                    $this->db->where($this->primary_key, $where);

                    return $this->db->update($this->table, $data);

                }

            }

        }

        return false;

    }

    public function delete($where = null, $silent = false){

        if(!$where){
            throw new Exception('Nenhuma condição informada para a clausula "where"');
        }

        if(is_array($where)){

            if($silent){
                
                if($this->db->field_exists('deleted', $this->table)){
                    $this->update(array(
                            'deleted' => 1
                        ), $where);
                }

            } else {

                foreach($where as $field => $value){

                    if ($value != 'IS NULL' or $value != 'IS NOT NULL'){
                        $this->db->where($field, $value);
                    } else {
                        $this->db->where($field.' '.$value);
                    }
                
                }

                $this->db->delete($this->table);

            }

        } 

    }

    public function count($where = null){

        if(is_array($where)){

            foreach($where as $field => $value){
                if ($value != 'IS NULL' or $value != 'IS NOT NULL'){
                    $this->db->where($field, $value);
                } else {
                    $this->db->where($field.' '.$value);
                }
            }

            return intval($this->db->count_all_results($this->table));

        } else {

            return intval($this->db->count_all_results($this->table));

        }

    }

    public function last($where = null, $orderfield = null, $limit = 1){

        if($limit < 1) {
            return false;
        }

        if($where){

            if(is_array($where)){

                foreach($where as $field => $value){

                    $this->db->where($field, $value);

                }
                
            } else {
                $this->db->where($this->primary_key, $where);
            }

        }

        if($orderfield){
            $this->db->order_by($orderfield.' DESC');
        } else {
            $this->db->order_by($this->primary_key.' DESC');
        }

        $this->db->limit($limit, 0);

        $result = $this->db->get($this->table);

        if($result->num_rows() > 0){
            if($limit == 1){
                return $result->row();
            } else if($limit >1){
                return $result->result();
            }
        } 

        return false;

    }

}
