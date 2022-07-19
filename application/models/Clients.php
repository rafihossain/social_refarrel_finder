<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clients extends CI_Model
{
    var $table = 'recommendations';
    var $column_order = array(null, 'crawler_id', 'fb_request_full_name', 'fb_request_content', 'fb_group_id', 'fb_post_id', 'fb_request_date', 'source', 'tags'); //set column field database for datatable orderable
    var $column_search = array('fb_request_full_name', 'tags', 'source'); //set column field database for datatable searchable 
    var $order = array('fb_request_date' => 'DESC'); // default order

    function __construct()
    {
        parent::__construct();
    }

    public function getAllClient()
    {
        $this->db->select('end_clients.end_client_id,end_clients.business_name,end_clients.end_client,end_clients.client_email');
        $this->db->from('end_clients');
        $this->db->join('users', 'users.id = end_clients.user_id', 'left');
        $this->db->where("users.account_level", 'client');
        $this->db->where("end_clients.active", 1);
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        // echo $this->db->last_query();

        return $result;
    }
    public function getMyKeywords($id = 0)
    {
        $this->db->select('keywords.id,keywords.keyword,recommendations.keyword_id, COUNT(recommendations.id) as totalid');
        if ($id  != 0) {
            $this->db->where("keywords.crawler_id", $id);
        }
        $this->db->from('keywords');
        $this->db->join('recommendations', 'recommendations.keyword_id = keywords.id');
        $this->db->group_by('recommendations.keyword_id');
        $this->db->limit(20);

        $query_result = $this->db->get();
        //echo $this->db->last_query();die();
        $result = $query_result->result();
        return $result;
    }
    public function getSingleClient($id)
    {
        $this->db->select('*');
        $this->db->from('end_clients');
        $this->db->where("end_client_id", $id);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function getAllActiveClient($id = 0)
    {
        $this->db->select('*');
        //$this->db->where("active",1);
        if ($id  != 0) {
            $this->db->where("associated_crawler_id", $id);
        }
        $this->db->from('end_clients');
        return $this->db->count_all_results();
    }

    public function getAllConntectedGroupp($id = 0)
    {
        $this->db->select('*');
        $this->db->where("connected", 1);
        if ($id  != 0) {
            $this->db->where_in("crawler_id", $id);
        }
        $this->db->from('groups');
        // echo $this->db->last_query();
        return $this->db->count_all_results();
    }
    public function getAllActiveKeyword($id = 0)
    {
        $this->db->select('*');
        $this->db->where("active", 1);
        if ($id  != 0) {
            $this->db->where_in("crawler_id", $id);
        }
        $this->db->from('keywords');
        return $this->db->count_all_results();
    }


    public function getAllClientFacebookGroup($id)
    {
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where("connected", 1);
        if ($id  != 0) {
            $this->db->where("crawler_id", $id);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function getAllCrawler()
    {
        $this->db->select('id,full_name');
        $this->db->from('users');
        $this->db->where("active", 1);
        $this->db->where("account_level", 'client');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function getAllTag($id = 0)
    {
        $this->db->select('*');
        $this->db->from('tags');
        $this->db->where("crawler_id", $id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function getAllKeywords($id)
    {
        $this->db->select('id,crawler_id,keyword,recommended_reply,active');
        $this->db->from('keywords');
        $this->db->where("client_id", $id);
        $this->db->where("active", 1);
        $query_result = $this->db->get();

        $result = $query_result->result();
        return $result;
    }

    public function insertData($table, $data)
    {
        $this->db->insert($table, $data);
        // echo $this->db->last_query();
        return $this->db->insert_id();
    }

    public function updateData($table, $data, $selector, $select)
    {
        $this->db->where($selector, $select);
        // echo $this->db->last_query();
        return $this->db->update($table, $data);
    }

    public function deleteData($table, $selector, $select)
    {
        $this->db->where($selector, $select);
        return $this->db->delete($table);
    }
    
    public function getKeywordIds(){
        $id = $this->session->userdata('id');
        $this->db->select('end_client_id');
        $this->db->from('end_clients');
        $this->db->where("user_id", $id);
        $query_result = $this->db->get();
        $end_client_id = $query_result->row()->end_client_id; 
        
        
        if($end_client_id){
            
         $this->db->select('id');
        $this->db->from('keywords');
        $this->db->where("end_client_id", $end_client_id);
        $query_result = $this->db->get();
        $keywords = $query_result->result_array();   
          
         if(count($keywords) > 0){
            $keyword_ids = array_column($keywords, 'id');
            return $keyword_ids;
         }
          
          return [];   
        }
           return [];   
       
    }


/*=======================================================================
                Client Recommendation Start
=========================================================================*/


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
        
    
        // $cl = $info['crawler_account_id'];
        
    //     if ($cl != null) {
    //     //$this->db->where_in('crawler_id', $info['crawler_account_id']);
    //     }
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

    public function getAllKeyWordIdBytext(){
        $client_id = $this->session->userdata('client_id');
        $this->db->select('id');
        $this->db->from('keywords');
        $this->db->where('end_client_id',$client_id);
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        // print_r($result); die();
        $ids = [];
        if(count($result) > 0){
        $ids = array_column($result,'id');  
        }
        
     return  $ids; 
    }


    public function getAllGroupId(){
        $id = $this->session->userdata('id');
        $getMulticrawlers = $this->Clients->getAllCrawlersUnderClient($id);
       
        $crawler = array_column($getMulticrawlers, 'crawler_id');
       
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where_in('crawler_id',$crawler);
        $query_result = $this->db->get();
        
        $result = $query_result->result_array();
            
        $result = array_column($result, 'fb_group_id');
        // echo $this->db->last_query();
        return $result; 
    }


    
      private function _get_datatables_query()
    {
        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }
        
        $groupId = $this->getAllGroupId();

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
         $getkewordId =  $this->getAllKeyWordIdBytext();
        $this->db->where_in('keyword_id', $getkewordId); 
        }

        $this->db->where_in('fb_group_id', $groupId);

        $id = $this->session->userdata('id');
        $this->db->where('user_id', $id);

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
        

    public function get_datatables($length, $start)
    {
        $this->_get_datatables_query();
        if ($length != -1)
        $this->db->limit($length, $start);
        $this->db->group_by('fb_request_full_name'); 
        $this->db->order_by('fb_request_date', 'DESC');
        $query = $this->db->get();
    //    echo $this->db->last_query();
      //  die();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $id = $this->session->userdata('id');

        $info = $this->input->post();
        if (count($info) > 0) {
        $this->session->set_userdata('searchInfo', $info);
        } else {
        $info = $this->session->userdata('searchInfo');
        }
        
        $groupId = $this->getAllGroupId();
        // echo "<pre>"; print_r($groupId); die();

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
         $getkewordId =  $this->getAllKeyWordIdBytext();
        //  echo "<pre>"; print_r($getkewordId); die();
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
        $this->db->where('user_id', $id);
        $this->db->from($this->table);
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
        $abc = $clientId;
        // $abc =  join(",", $clientId);
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
                Client Recommendation End
=========================================================================*/



    public function getMyAllKeywords($id)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where("end_client_id", $id);
        $this->db->where("active", 1);
        $query_result = $this->db->get();

        $result = $query_result->result();
        return $result;
    }
    public function getSingleKeyword($id = 0)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where("id", $id);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }


    /*=========================================
                    Ambassador
                    ==========================================*/
    public function getAllTeamMember()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where("account_level", 'ambassador');
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }

    public function teammemberDepand($id)
    {
        $this->db->select('ambassador_match.user_id, users.full_name');
        $this->db->from('ambassador_match');
        $this->db->join('users', 'users.id = ambassador_match.user_id');
        $this->db->where("ambassador_id", $id);
        $query_result = $this->db->get();

        $result = $query_result->result_array();
        return $result;
    }

    public function multiCrawlersInfoForClient($id)
    {
        $this->db->select('crawler_id');
        $this->db->from('end_clients');
        $this->db->join('multiple_crawler', 'end_clients.end_client_id = multiple_crawler.end_client_id');
        $this->db->where("end_clients.end_client_id", $id);
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        $results = array_column($result, 'crawler_id');
        return $results;
    }

    public function getAllCrawlers()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where("account_level", 'crawler');
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }

    public function getAllRelatedCrawler($id)
    {
        $this->db->select('*');
        $this->db->from('multiple_crawler');
        $this->db->where("end_client_id", $id);
        $query_result = $this->db->get();
        $result = $query_result->result_array();

        if (count($result) > 0) {
            for ($i = 0; $i < count($result); $i++) {
                $this->db->select('users.full_name');
                $this->db->from('users');
                $this->db->where('users.id', $result[$i]['crawler_id']);
                $query_result = $this->db->get();
                $rows = $query_result->row();
                $result[$i]['full_name'] = $rows->full_name;
            }
        }
        $result = array_column($result, 'full_name');
        return $result;
    }

    public function deleteMultiCrawlersData($dropInfo)
    {
        $this->db->where('end_client_id', $dropInfo['end_client_id']);
        $this->db->where('crawler_id', $dropInfo['crawler_id']);
        return $this->db->delete('multiple_crawler');
    }

    public function getCrawlerToClientUserId($id){
        $this->db->select('*');
        $this->db->from('multiple_crawler');
        $this->db->where("crawler_id", $id);
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        if (count($result) > 0) {
            for ($i = 0; $i < count($result); $i++) {
                $this->db->select('user_id,end_client_id');
                $this->db->from('end_clients');
                $this->db->where('end_client_id', $result[$i]['end_client_id']);
                $query_result = $this->db->get();
                $result[$i] = $query_result->row_array();
            }
        }
        $result = array_column($result, 'user_id');

        return $result;
    }
    
    public function getAllCrawlersUnderClient($id)
    {
        $this->db->select('end_clients.end_client_id,end_clients.user_id,multiple_crawler.crawler_id');
        $this->db->from('end_clients');
        $this->db->where('end_clients.user_id', $id);
        $this->db->join('multiple_crawler','end_clients.end_client_id = multiple_crawler.end_client_id');
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }

    public function getUserInfo($id, $sort = 0)
    {
        $this->db->select('id,full_name');
        $this->db->from('users');
        $this->db->where_in("id", $id);

        if ($sort == 1) {
            $this->db->order_by("full_name", 'ASC');
        }
        if ($sort == 2) {
            $this->db->order_by("full_name", 'DESC');
        }

        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function getAllActiveRecommandedRequest()
    {
        $this->db->from('recommendations');
        $query = $this->db->get();
        return $query->num_rows();
    }


}
