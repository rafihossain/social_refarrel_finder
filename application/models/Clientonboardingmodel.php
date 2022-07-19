<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clientonboardingmodel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getFacebookGroupInformation($crawlerId)
    {
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where_in("groups.crawler_id", $crawlerId);
        $query_result = $this->db->get();
        $result = $query_result->result_array();

        // echo $this->db->last_query();
        return $result;
    }
    public function fetchClientOnboardingFbgroups()
    {
        $this->db->select('*');
        $this->db->from('clientonboarding_fbgroups');
        $query_result = $this->db->get();
        $result = $query_result->result_array();

        // echo $this->db->last_query();
        return $result;
    }
    public function teammemberDepand($id, $sort = 0)
    {
        $this->db->select('ambassador_match.user_id, users.full_name');
        $this->db->from('ambassador_match');
        $this->db->join('users', 'users.id = ambassador_match.user_id');

        $this->db->where("ambassador_id", $id);
        if ($sort == 1) {
            $this->db->order_by("full_name", 'ASC');
        }
        if ($sort == 2) {
            $this->db->order_by("full_name", 'DESC');
        }
        
        $query_result = $this->db->get();

        // echo $this->db->last_query();

        $result = $query_result->result_array();
        return $result;
    }

    public function adminCategoryFilter($id, $sort = 0)
    {
        $this->db->select('ambassador_match.user_id, users.full_name');
        $this->db->from('ambassador_match');
        $this->db->join('users', 'users.id = ambassador_match.user_id');

        $this->db->where("ambassador_id", $id);
        
        if ($sort == 1) {
            $this->db->order_by("users.full_name", 'ASC');
        }
        if ($sort == 2) {
            $this->db->order_by("users.full_name", 'DESC');
        }
        
        $query_result = $this->db->get();

        // echo $this->db->last_query();

        $result = $query_result->result_array();
        return $result;
    }
    
    public function getAllSuggestedKeyword()
    {
        $this->db->select('*');
        $this->db->from('suggested_keyword');
        $query_result = $this->db->get();

        $result = $query_result->result_array();
        return $result;
    }
    public function getCrawlerGroupInformation($crawlerId, $groupId)
    {
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where_in('crawler_id', $crawlerId);
        $this->db->where('id', $groupId);
        $query_result = $this->db->get();
        $result = $query_result->row_array();

        // echo $this->db->last_query();
        return $result;
    }


    public function insertData($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    public function updateData($table, $data, $selector, $select)
    {
        $this->db->where($selector, $select);

        return $this->db->update($table, $data);
    }
    public function deleteData($table, $selector, $select)
    {
        $this->db->where($selector, $select);
        return $this->db->delete($table);
    }
}
