<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Model
{
    /*
     *  Developed by: Active IT zone
     *  Date    : 18 September, 2017
     *  Active Matrimony CMS
     *  http://codecanyon.net/user/activeitezone
     */

    function __construct()
    {
        parent::__construct();
    }

    function check_login($table, $username, $password)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('email', $username);
        $this->db->where('password', $password);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }
    
    //password reset
    function getUsers($table, $email)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('email', $email);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }
    
    function getAllUsers()
    {
        $this->db->select('id, email, full_name');
        $this->db->from('users');
        $this->db->where('daily_report', 1);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    function getMatchToken($table, $userToken)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('password_uid', $userToken);
        $query_result = $this->db->get();
        $result = $query_result->row_array();
        return $result;
    }

    public function getCrawlersData($id){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $id);
        $this->db->where("account_level",'client');
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function updateData($table, $data, $selector, $select)
    {
        $this->db->where($selector, $select);
        return $this->db->update($table, $data);
        // echo $this->db->last_query();
    }

    public function getClientId($id){
        $this->db->select('*');
        $this->db->from('end_clients');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getEmailValiditeCheckData($email){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $result = $query->row();

        // echo $this->db->last_query();
        return $result;
    }
    
    
}