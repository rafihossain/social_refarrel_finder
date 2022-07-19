<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ambassadormodel extends CI_Model
{
    var $table = 'recommendations';
    var $column_order = array(null, 'crawler_id', 'fb_request_full_name', 'fb_request_content', 'fb_group_id', 'fb_post_id', 'fb_request_date', 'source', 'tags'); //set column field database for datatable orderable
    var $column_search = array('fb_request_full_name', 'tags', 'source'); //set column field database for datatable searchable 
    var $order = array('fb_request_date' => 'DESC'); // default order

    function __construct()
    {
        parent::__construct();
    }
        // public function getAllAmbassadors(){
        //     $this->db->select('*');
        //     $this->db->from('users');
        //   //  $this->db->where("active",1);
        //     $this->db->join('ambassador_reports', 'users.id = ambassador_reports.user_id', 'left');
        //     $this->db->where("account_level",'ambassador');
        //     $this->db->order_by('users.id','DESC');
        //     $query_result = $this->db->get();
        //     $result = $query_result->result();
    
        //     // echo $this->db->last_query(); 
    
        //     return $result;
        // }

    public function getAmbassadors(){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where("account_level",'ambassador');
           // $this->db->where("active",1);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function getAllReports($id){
        $this->db->select('*');
        $this->db->from('ambassador_reports');
        $this->db->where("user_id",$id);
            //$this->db->where("active",1);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }
    public function getAllClients(){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where("account_level",'crawler');
        $this->db->where("active",1);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function getRecommandedRecoquest($stdate,$enddate,$id=''){

        if($id != ''){
            $this->db->where_in('user_id', $id);
        }
        $this->db->where('fb_request_date >=',  $stdate);
        $this->db->where('fb_request_date <=',  $enddate);

        $this->db->from('recommendations');
        $query = $this->db->get();

        // echo $this->db->last_query();
        return $query->num_rows();

    }

    public function getAllAmbsclient($id){
        $this->db->select('user_id');
        $this->db->from('ambassador_match');
        $this->db->where("ambassador_id",$id);
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query();
        // echo "<pre>"; print_r($result); die();

        $mydata  =[];
        if(count($result) > 0){
            $mydata = array_map(function($o) {
                return is_object($o) ? $o->user_id : $o['user_id'];
            }, $result);

        }else{
            $mydata  =[];
        }
        return $mydata;
    }

        // public function getAmbassadorsReport(){
        //     $this->db->select('*');
        //     $this->db->from('Album a'); 
        //     $this->db->join('Category b', 'b.cat_id=a.cat_id', 'left');
        //     $this->db->join('Soundtrack c', 'c.album_id=a.album_id', 'left');
        //     $this->db->where('c.album_id',$id);
        //     $this->db->order_by('c.track_title','asc');         
        //     $query = $this->db->get(); 
        // }

    
    /*=======================================================================
                Ambassador Crawler Recommendation Start
    =========================================================================*/
    public function getCrawlersUnderClient($id)
    {
        $this->db->select('end_clients.end_client_id,end_clients.user_id,multiple_crawler.crawler_id');
        $this->db->from('end_clients');
        $this->db->where_in('end_clients.user_id', $id);
        $this->db->join('multiple_crawler','end_clients.end_client_id = multiple_crawler.end_client_id');
        $query_result = $this->db->get();
        $result = $query_result->result_array();

        // echo $this->db->last_query();
        return $result;
    }

    public function getKeyWordIdBytext(){
     
        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }
     
        if($info['exact_match'] == 1){
        $text = explode(',',$info['txtTriggers']); 
        }
        
        $this->db->where_in('keyword', $text);
        $this->db->select('id');
        $this->db->from('keywords');
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        $ids = [];
        if(count($result) > 0){
        $ids = array_column($result,'id');  
        }

        return  $ids;
    }
    
    public function getAllKeyWordIdBytext($crawlerId){
        
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where_in('crawler_id',$crawlerId);
        
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        
        $ids = [];
        if(count($result) > 0){
            $ids = array_column($result,'id');  
        }
        
        return $ids; 
    }
    
     public function getAllGroupId($crawler){
         
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where_in('crawler_id',$crawler);
        $query_result = $this->db->get();
        
        $result = $query_result->result_array();
            
        $result = array_column($result, 'fb_group_id');
        return $result; 
    }
    
    
    private function _get_datatables_query($clientId, $crawlerId)
    {

        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }
        
        $groupId = $this->getAllGroupId($crawlerId);
        
        if($info['txtTriggers'] != ''){
         $getkewordId =  $this->getKeyWordIdBytext();
         
         if(count($getkewordId) == ''){
            //  echo 11; die();
            $this->db->like('recommendations.fb_request_content', $info['txtTriggers']); 
         }else{
            // echo 22; die();
            $this->db->where_in('keyword_id', $getkewordId); 
         }

        }else{
         $getkewordId =  $this->getAllKeyWordIdBytext($crawlerId);
         $this->db->where_in('keyword_id', $getkewordId); 
        }
        
        $this->db->where_in('fb_group_id', $groupId);
        
        if ($clientId != null) {
            $this->db->where_in('user_id', $clientId);
        }
        if ($info['filter_tags'][0] == 0) {
        } elseif ($info['filter_tags'][0] == 1) {
            $this->db->where('tags !=', '');
            $this->db->where('tags !=', null);
        } elseif ($info['filter_tags'][0] == 2) {
            $this->db->where('tags', '');
            $this->db->or_where('tags', null);
        } elseif ($info['filter_tags'][0] == 4) {
            $this->db->where('tags !=', '');
            $this->db->where('tags !=', null);

            $aaa = $info['filter_tags'];
            unset($aaa[0]);

            foreach ($aaa as $aa) {
                $this->db->or_like('tags', $aa);
            }
        }

        if ($info['datepicker_from'] != '') {

            $this->db->where('fb_request_date >=',  $info['datepicker_from'] . ' 00:00:00');
        } else {

            $this->db->where('fb_request_date >=',  date("Y-m-d") . ' 00:00:00');
        }
        if ($info['datepicker_to'] != '') {

            $this->db->where('fb_request_date <=',  $info['datepicker_to'] . ' 23:59:59');
        } else {
            $this->db->where('fb_request_date <=',   date("Y-m-d") . ' 23:59:59');
        }
        
        $this->db->from($this->table);


    }


    public function getCrawlersDatatables($length, $start, $clientId, $crawlerId)
    {
        $this->_get_datatables_query($clientId, $crawlerId);
        if ($length != -1)
        $this->db->limit($length, $start);
        $this->db->group_by('fb_request_full_name');
        $this->db->order_by('fb_request_date', 'DESC');
        $query = $this->db->get();
        
        // echo $this->db->last_query();
        // die();
        return $query->result();
    }

    public function count_all($clientId, $crawlerId)
    {
        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }
        
        $groupId = $this->getAllGroupId($crawlerId);
        
        if($info['txtTriggers'] != ''){
         $getkewordId =  $this->getKeyWordIdBytext();

         if(count($getkewordId) == ''){
            //  echo 11; die();
            $this->db->like('recommendations.fb_request_content', $info['txtTriggers']); 
         }else{
            // echo 22; die();
            $this->db->where_in('keyword_id', $getkewordId); 
         }

        }else{
         $getkewordId =  $this->getAllKeyWordIdBytext($crawlerId);
        //  print_r($getkewordId); die();
         $this->db->where_in('keyword_id', $getkewordId); 
        }
        
        $this->db->where_in('fb_group_id', $groupId);
        
        if ($info['filter_tags'][0] == 0) {
        } elseif ($info['filter_tags'][0] == 1) {
            $this->db->where('tags !=', '');
            $this->db->where('tags !=', null);
        } elseif ($info['filter_tags'][0] == 2) {
            $this->db->where('tags', '');
            $this->db->or_where('tags', null);
        } elseif ($info['filter_tags'][0] == 4) {
            $this->db->where('tags !=', '');
            $this->db->where('tags !=', null);

            $aaa = $info['filter_tags'];
            unset($aaa[0]);

            foreach ($aaa as $aa) {
                $this->db->or_like('tags', $aa);
            }
        }

        if ($info['datepicker_from'] != '') {

            $this->db->where('fb_request_date >=',  $info['datepicker_from'] . ' 00:00:00');
        } else {

            $this->db->where('fb_request_date >=',  date("Y-m-d") . ' 00:00:00');
        }
        if ($info['datepicker_to'] != '') {

            $this->db->where('fb_request_date <=',  $info['datepicker_to'] . ' 23:59:59');
        } else {
            $this->db->where('fb_request_date <=',   date("Y-m-d") . ' 23:59:59');
        }

        $this->db->group_by('fb_request_full_name');
        $this->db->where_in('user_id', $clientId);
        $this->db->from($this->table);
        
        // echo $this->db->last_query();
        return $this->db->count_all_results();
    }


    /*----------------------------------------
                    custome
    -----------------------------------------*/

    public function _get_datatables_queryCustom($clientId)
    {

        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }
        $tags = $info['filter_tags'];

        // echo "hi"; die();
        // print_r($users); die(); 

        // echo $this->db->last_query();
		
		// $users = $this->Crawler->getCrawlerUserInfo($crawler);


        // echo "<pre>"; print_r($users); die();

        unset($tags[0]);


        $i = 1;
        $html = '';
        foreach ($tags as $tag) {

            $html .= " tags LIKE '%" . $tag . "%' ";

            if ($i != count($tags)) {
                $html .= " ESCAPE '!' OR ";
            }
            $i++;
        }
        $abc =  join(",", $clientId);
        // echo "<pre>"; print_r($abc); die();

        // if ($info['datepicker_from'] != '') {

        //     $this->db->where('fb_request_date >=',  $info['datepicker_from'] . ' 00:00:00');
        // } else {

        //     $this->db->where('fb_request_date >=',  date("Y-m-d") . ' 00:00:00');
        // }
        // if ($info['datepicker_to'] != '') {

        //     $this->db->where('fb_request_date <=',  $info['datepicker_to'] . ' 23:59:59');
        // } else {
        //     $this->db->where('fb_request_date <=',   date("Y-m-d") . ' 23:59:59');
        // }
        

        // $this->db->from($this->table);

        $from = ($info['datepicker_from'] != '' ? $info['datepicker_from'] : date("Y-m-d"));
        $to = ($info['datepicker_to'] != '' ? $info['datepicker_to'] : date("Y-m-d"));
        $str = "SELECT * FROM `recommendations` WHERE (" . $html . ") AND `user_id` IN (" . $abc . ")  AND `fb_request_date` >= '" . $from . "' AND `fb_request_date` <= '" . $to . "' GROUP BY `id` ";
        return $str;
    }


    public function get_datatablesCustom($length, $start, $clientId)
    {
        $str =  $this->_get_datatables_queryCustom($clientId);
        if ($length != -1)
            $str .= "Limit " . $start . "," . $length;
            $this->db->order_by('fb_request_date', 'DESC');

        $result = $this->db->query($str)->result();
        return  $result;
    }
    public function count_allForCustom($clientId)
    {
        $str = $this->_get_datatables_queryCustom($clientId);
        $query_result = $this->db->query($str);
        return $query_result->num_rows();
    }

    public function getkeyWord($keyword_id)
    {
        $this->db->reset_query();
        // echo $keyword_id; die();
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where('id', $keyword_id);
        // $this->db->order_by('id', 'desc');
        $test = $this->db->get();
        // echo $this->db->last_query().'hello';
        
        // echo $this->db->last_query(); die();

        $result = $test->row();

        if ($result) {
            $str =  "<span class='me-2'>" . $result->keyword . "</span><span class='tag-comma'>, </span>";
            return $str;
        }

        return '';
    }




    /*=======================================================================
            Ambassador Crawler Recommendation End
    =========================================================================*/






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
    
    public function deleteAmData($dropInfo){
        $this->db->where('ambassador_id',$dropInfo['ambassador_id']);
        $this->db->where('user_id',$dropInfo['client_id']);
        return $this->db->delete('ambassador_match');
    }

    public function getSelectedGroupCategories($crawlerId){
        // echo $crawlerId; die();
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where('crawler_id',$crawlerId);
        $this->db->where('status', 1);
        $query_result = $this->db->get();
        
        // echo $this->db->last_query(); die();
        
        $result = $query_result->result_array();

        return $result;
    }

    public function getSelectedKeyword($crawlerId){

        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where('crawler_id',$crawlerId);
        $query_result = $this->db->get();
        
        $result = $query_result->result_array();

        // echo $this->db->last_query();
        return $result;
    }

    public function getAllCrawlerUnderAmbassadors($id, $sort = 0)
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

        $result = $query_result->result();
        return $result;
    }

    public function getSpecificAmbassadors($id){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where("account_level",'ambassador');
        $this->db->where("id", $id);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }
    


}