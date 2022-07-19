<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Plans extends CI_Model
{

    public function getAllPlans(){
        $this->db->select('*');
        $this->db->from('plans'); 
        $query_result = $this->db->get();
        $result= $query_result->result();
        return $result;
    }

    public function insertData($table,$data){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }
        
    public function updateData($table,$data,$selector,$select){
        $this->db->where($selector,$select);
        return $this->db->update($table,$data);
    }
        
    public function deleteData($table,$selector,$select){
        $this->db->where($selector,$select);
        return $this->db->delete($table);
    }


}