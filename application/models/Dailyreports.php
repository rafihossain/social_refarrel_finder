<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dailyreports extends CI_Model
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


    public function getDataFromReports($userId = '', $sendDate = '')
    {
        $this->db->select('*');
        $this->db->from('daily_reports');
        if($userId != ''){
            $this->db->where('user_id', $userId);
        }
        if($sendDate != ''){
            $this->db->where("send_date", $sendDate);
        }
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    public function recommendationsTotalRequest($yesterday, $recomId = ''){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->where('fb_request_date >=', $yesterday . ' 00:00:00'); 
        $this->db->where('fb_request_date <=', $yesterday . ' 23:59:59');
        if($recomId != ''){
            $this->db->where('user_id', $recomId); 
        }
        $query_result = $this->db->get();
        $result = $query_result->num_rows();

        // echo $this->db->last_query();
        return $result;
    }
    public function recommendationsTotalRequestNoTag($yesterday, $recomId){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->where('tags', ''); 
        $this->db->where('fb_request_date >=', $yesterday . ' 00:00:00'); 
        $this->db->where('fb_request_date <=', $yesterday . ' 23:59:59'); 
        // $this->db->where('crawler_id', $recomId); 
        $query_result = $this->db->get();
        $result = $query_result->num_rows();

        // echo $this->db->last_query();
        return $result;
    }
    public function recommendationsQueryByTag($yesterday, $recomId, $tag){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->where('tags', ','.$tag.','); 
        $this->db->where('fb_request_date >=', $yesterday . ' 00:00:00'); 
        $this->db->where('fb_request_date <=', $yesterday . ' 23:59:59'); 
        $this->db->where('crawler_id', $recomId); 
        $query_result = $this->db->get();
        $result = $query_result->num_rows();

        // echo $this->db->last_query();
        return $result;
    }
    public function getTagForthisUser($recomId){
        $this->db->select('*');
        $this->db->from('tags');
        $this->db->where('daily_report', 1);
        $this->db->where('crawler_id', $recomId); 
        $this->db->order_by('tag', 'ASC'); 
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query();
        return $result;
    }

    /*=============================================
                    Admin Conjob
    ===============================================*/

    public function getAllAdminConjobClients(){
        $this->db->select('users.id,users.email,users.full_name,users.current_plan,users.active,users.zoho_customer_id,plans.plan_code,plans.plan_name');
        $this->db->from('users');
        $this->db->join('plans', 'users.current_plan = plans.plan_code');
        $this->db->where('users.account_level', 'client');
        $this->db->order_by('users.full_name', 'ASC');
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query();
        return $result;
    }
    public function getAdminConjobClients($clientId){
        $this->db->select('crawler_id');
        $this->db->from('multiple_crawler');
        $this->db->where('crawler_id', $clientId);
        // $this->db->where('active', 1);
        $query_result = $this->db->get();
        $result = $query_result->result();
            return $result;

        // if(count($result) >  0){
        //     $results = array_column($result, 'crawler_id');
        // }
        // echo $this->db->last_query();
    }
    public function getAdminUsersConjob(){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('account_level', 'admin');
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query();
        return $result;
    }
    public function getAmbassadorUsersConjob(){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('account_level', 'ambassador');
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query();
        return $result;
    }
    public function getTotalTriggeredPosts($yesterday){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->like('fb_request_date', $yesterday);
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query();
        return $result;
    }
    public function getAmbassadorNameTag($nameTag, $yesterday){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->like('tags', $nameTag);
        $this->db->like('fb_request_date', $yesterday);
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query();
        return $result;
    }
    public function getTaggedPost($yesterday){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->like('fb_request_date', $yesterday);
        $this->db->where('tags !=', '');
        $result = $this->db->get();

        // echo $this->db->last_query();
        return $result->num_rows();
    }
    public function getNotRelatedPosts($yesterday){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->like('fb_request_date', $yesterday);
        $this->db->like('tags', 'not-relevant');
        $result = $this->db->get();

        // echo $this->db->last_query();
        return $result->num_rows();
    }
    public function getRecommended($yesterday){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->like('fb_request_date', $yesterday);
        $this->db->like('tags', 'recommended');
        $result = $this->db->get();

        // echo $this->db->last_query();
        return $result->num_rows();
    }
    public function getNotTaggedPosts($yesterday){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->like('fb_request_date', $yesterday);
        $this->db->where('tags', '');
        $result = $this->db->get();

        // echo $this->db->last_query();
        return $result->num_rows();
    }


    /*=================================
			name tags model
	==================================*/

    public function getNameTaggedPosts($yesterday, $nameTag){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->like('fb_request_date', $yesterday);
        $this->db->like('tags', $nameTag);
        $result = $this->db->get();

        // echo $this->db->last_query();
        return $result->num_rows();
    }
    public function getNameTagNotRelatedPosts($yesterday, $nameTag){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->like('fb_request_date', $yesterday);
        $this->db->where('tags !=', '');
        $this->db->like('tags', $nameTag);
        $result = $this->db->get();

        // echo $this->db->last_query();
        return $result->num_rows();
    }
    public function getNameTagRecommended($yesterday, $nameTag){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->like('fb_request_date', $yesterday);
        $this->db->like('tags', 'not-relevant');
        $this->db->like('tags', $nameTag);
        $result = $this->db->get();

        // echo $this->db->last_query();
        return $result->num_rows();
    }
    public function getNotNameTaggedPosts($yesterday, $nameTag){
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->like('fb_request_date', $yesterday);
        $this->db->like('tags', 'recommended');
        $this->db->like('tags', $nameTag);
        $result = $this->db->get();

        // echo $this->db->last_query();
        return $result->num_rows();
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
        // echo $this->db->last_query();
    }

    public function deleteData($table, $selector, $select)
    {
        $this->db->where($selector, $select);
        return $this->db->delete($table);
    }
    
    
}