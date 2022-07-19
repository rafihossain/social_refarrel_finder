<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crawler extends CI_Model
{
    var $table = 'recommendations';
    var $column_order = array(null, 'crawler_id', 'fb_request_full_name', 'fb_request_content', 'fb_group_id', 'fb_post_id', 'fb_request_date', 'source', 'tags'); //set column field database for datatable orderable
    var $column_search = array('fb_request_full_name', 'tags', 'source'); //set column field database for datatable searchable 
    var $order = array('fb_request_date' => 'DESC'); // default order

    function __construct()
    {
        parent::__construct();
    }

    // public function getAllClient()
    // {
    //     $this->db->select('*');
    //     $this->db->from('end_clients');
    //     $this->db->where("associated_crawler_id", 0);
    //     $query_result = $this->db->get();
    //     $result = $query_result->result();
    //     return $result;
    // }

    public function getAllPlan()
    {
        $this->db->select('*');
        $this->db->from('plans');
        $this->db->where("plan_name !=", 'NA');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    public function getAllTimzones()
    {
        $this->db->select('value');
        $this->db->from('timzones');
        $query_result = $this->db->get();
        $result = $query_result->result();
        $newArray = array_map(function ($o) {
            return is_object($o) ? $o->value : $o['value'];
        }, $result);
        return $newArray;
    }

    public function getUserInfo($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where("id", $id);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    // public function getMyClients($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('end_clients');
    //     $this->db->where("associated_crawler_id", $id);
    //     $query_result = $this->db->get();
    //     $result = $query_result->result();
    //     return $result;
    // }

    public function getAllGroups($id)
    {
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where("crawler_id", $id);
        $this->db->where("connected", 1);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    public function getAllTags($id)
    {
        $this->db->select('*');
        $this->db->from('tags');
        $this->db->where("crawler_id", $id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }



    public function whereInClient($ids, $id)
    {
        $this->db->where_in('end_client_id', $ids);
        return $this->db->update('end_clients', ['associated_crawler_id' => $id]);
        // echo $this->db->last_query();
    }

    public function getMyKeyowrd($id)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where_in('crawler_id', $id);
        $query_result = $this->db->get();
        $nresult = $query_result->result();

        if (count($nresult) > 0) {
            $mydata =  $nresult;
        } else {
            $mydata  = [];
        }
        return $mydata;
    }

    public function whereInClientKeyword($ids, $id)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where_in('end_client_id', $ids);
        $query_result = $this->db->get();
        $result = $query_result->result();

        $mydata = [];

        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where_in('crawler_id', $id);
        $query_result = $this->db->get();
        $nresult = $query_result->result();

        if (count($nresult) > 0) {
            $mydata = array_merge($result, $nresult);
        } else {
            $mydata  = $result;
        }

        return $mydata;
    }

    public function getGroupData($id, $cid)
    {
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where("id", $id);
        $this->db->where("crawler_id", $cid);
        $this->db->where("connected", 1);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function getRecommendationsMonth($startDate, $endDate, $id = 0)
    {
        $this->db->select('id');
        $this->db->from('recommendations');
        $this->db->where('fb_request_date >=', $startDate);
        $this->db->where('fb_request_date <=', $endDate);
        if ($id != 0) {
            $this->db->where('crawler_id', $id);
        }

        return $this->db->count_all_results();
    }


    // public function countAllRecommendationsByFilter($start_str, $end_str, $id = '')
    // {
    //     $this->db->select('COUNT(recommendations.id) as ids,groups.fb_group_name');
    //     // $this->db->select('COUNT(id) as ids,fb_group_id');
    //     $this->db->from('recommendations');
    //     $this->db->join('groups', 'recommendations.fb_group_id = groups.fb_group_id');
    //     $this->db->where('recommendations.fb_request_date >=', $start_str);
    //     $this->db->where('recommendations.fb_request_date <=', $end_str);

    //     if ($id != '') {
    //         $this->db->where_in('user_id', $id);
    //     }

    //     $this->db->group_by('recommendations.fb_group_id');
    //     $this->db->order_by("recommendations.id", "asc");
    //     $query_result = $this->db->get();
    //     $result = $query_result->result_array();

    //     // echo $this->db->last_query();
    //     // die();
    //     return $result;
    // }

    public function countAllRecommendationsByFilter($start_str, $end_str, $id = '')
    {
        $this->db->select('COUNT(recommendations.id) as ids,groups.fb_group_name, groups.fb_group_id');
        // $this->db->select('COUNT(id) as ids,fb_group_id');
        $this->db->from('recommendations');
        $this->db->join('groups', 'recommendations.fb_group_id = groups.fb_group_id');
        $this->db->where('recommendations.fb_request_date >=', $start_str);
        $this->db->where('recommendations.fb_request_date <=', $end_str);

        if ($id != '') {
            $this->db->where_in('user_id', $id);
        }

        $this->db->group_by('recommendations.fb_group_id');
        $this->db->order_by("recommendations.id", "asc");
        $query_result = $this->db->get();
        $result = $query_result->result_array();

        // echo $this->db->last_query();
        // die();
        return $result;
    }

    //Count Days
    public function getRecommendationsChartValueDay($start_str, $end_str, $id = '')
    {
        $this->db->select('COUNT(id) as ids, fb_request_date');
        $this->db->from('recommendations');
        $this->db->where('fb_request_date >=', $start_str);
        $this->db->where('fb_request_date <=', $end_str);

        if ($id != '') {
            $this->db->where_in('user_id', $id);
        }

        $this->db->group_by("DATE(fb_request_date)");
        $this->db->order_by('fb_request_date', 'ASC');
        $query_result = $this->db->get();
        $result = $query_result->result_array();

        //  echo $this->db->last_query();
        return $result;
    }

    public function getRecommendationsChartValue($start_str, $end_str, $id = '')
    {
        $this->db->select('id,fb_request_date');
        $this->db->from('recommendations');
        $this->db->where('fb_request_date >=', $start_str);
        $this->db->where('fb_request_date <=', $end_str);
        if($id != ''){
            $this->db->where_in('user_id', $id);
        }
        $this->db->order_by('fb_request_date', 'ASC');
        $query_result = $this->db->get();
        // $result = $query_result->result_array();
        $result = $query_result->num_rows();

        // echo $this->db->last_query();
        return $result;
    }

    //Count Keyword Search
    public function countSearchKeywordValue($keyword = '')
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where("account_level", 'crawler');
        if ($keyword != '') {
            $this->db->like("full_name", $keyword);
        }
        $result = $this->db->get();

        // echo $this->db->last_query();
        return $result->num_rows();
    }

    //Get Keyword Search
    public function getSearchKeywordValue($limit, $start, $keyword = '')
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where("account_level", 'crawler');
        // $this->db->where("active", 1);

        if ($keyword != '') {
            $this->db->like("full_name", $keyword);
        }
        $this->db->limit($limit, $start);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    //Get Keyword Search
    public function getAssendingAndDesendingCrawler($limit, $start, $keyword, $sort = 0)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where("account_level", 'crawler');
        $this->db->like("full_name", $keyword);
        $this->db->limit($limit, $start);
        if ($sort == 1) {
            $this->db->order_by("users.full_name", 'ASC');
        }
        if ($sort == 2) {
            $this->db->order_by("users.full_name", 'DESC');
        }

        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function updateGroup($table, $data, $id, $cid)
    {
        $this->db->where("id", $cid);
        $this->db->where("crawler_id", $id);
        // echo $this->db->last_query();
        return $this->db->update($table, $data);
    }

    public function insertData($table, $data)
    {
        $this->db->insert($table, $data);
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
        // echo $this->db->last_query();
        return $this->db->delete($table);
    }

    public function getMyInfo($id, $pass)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $id);
        $this->db->where('password', $pass);
        $query_result = $this->db->get();
        $nresult = $query_result->result();

        if (count($nresult) > 0) {
            $mydata = true;
        } else {
            $mydata  = false;
        }
        return $mydata;
    }

    public function notificationSettings($id)
    {
        $this->db->select('*');
        $this->db->from('notification_settings');
        $this->db->where('crawler_id', $id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return  $result;
    }


    public function getSingleKeyword($id)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where_in('id', $id);
        $query_result = $this->db->get();
        $nresult = $query_result->row();
        return $nresult;
    }

    public function viewKeyword($id)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where('end_client_id', $id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function getClientsinfo($id)
    {
        $this->db->select('*');
        $this->db->from('end_clients');
        $this->db->where("end_client_id", $id);
        $query_result = $this->db->get();
        $result = $query_result->row();

        return $result;
    }


    public function getMultiCrawlersInfo($id)
    {
        $this->db->select('crawler_id');
        $this->db->from('end_clients');
        $this->db->join('multiple_crawler', 'end_clients.end_client_id = multiple_crawler.end_client_id');
        $this->db->where("end_clients.end_client_id", $id);
        $query_result = $this->db->get();
        $result = $query_result->result_array();

        $results = array_column($result, 'crawler_id');
        // echo $this->db->last_query();
        return $results;
    }

    public function getAllCrawlerKeywords($id)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where("crawler_id", $id);
        $this->db->where("active", 1);
        $query_result = $this->db->get();

        $result = $query_result->result();
        return $result;
    }

    public function getCrawlersinfo($id)
    {
        $this->db->select('full_name');
        $this->db->from('users');
        $this->db->where("id", $id);
        $this->db->where("active", 1);
        $query_result = $this->db->get();

        $result = $query_result->row();
        return $result;
    }



/*=======================================================================
        Crawler Recommendation Start
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
        
        $this->db->where_in('keyword', $text);
        // $this->db->where_in('keyword', $text);
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
        $crawler = $this->session->userdata('id');
        $this->db->select('id');
        $this->db->from('keywords');
        $this->db->where('crawler_id',$crawler);
        
        $query_result = $this->db->get();
        // echo $this->db->last_query();

        $result = $query_result->result_array();
        $ids = [];
        if(count($result) > 0){
            $ids = array_column($result,'id');  
        }
    
        
     return  $ids; 
    }
    
     public function getAllGroupId(){
        $crawler = $this->session->userdata('id');
	   
	    $this->db->select('*');
        $this->db->from('groups');
        $this->db->where_in('crawler_id',$crawler);
        $query_result = $this->db->get();
        
        $result = $query_result->result_array();
            
        $result = array_column($result, 'fb_group_id');
        return $result; 
    }


    private function _get_datatables_query($data)
    {

        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }

        // echo $info['txtTriggers']; die();

         
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
        
        if ($data != null) {
            $this->db->where_in('user_id', $data);
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


    public function getCrawlersDatatables($length, $start, $data)
    {
        $this->_get_datatables_query($data);
        if ($length != -1)
        $this->db->limit($length, $start);
        $this->db->group_by('fb_request_full_name');
        $this->db->order_by('fb_request_date', 'DESC');
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result();
    }

    public function count_filtered($id)
    {
        $this->_get_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($id)
    {
        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }


        $groupId = $this->getAllGroupId();
        
        if($info['txtTriggers'] != ''){
            // echo 11; die();
         $getkewordId =  $this->getKeyWordIdBytext();
        
         if(count($getkewordId) == ''){
            //  echo 11; die();
            $this->db->like('recommendations.fb_request_content', $info['txtTriggers']); 
         }else{
            // echo 22; die();
            $this->db->where_in('keyword_id', $getkewordId); 
         }

        //  echo "<pre>"; print_r($getkewordId); die();

        }else{
            //  echo 33; die();
            // echo 22; die();
         $getkewordId =  $this->getAllKeyWordIdBytext();
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
        $this->db->where_in('user_id', $id);
        $this->db->from($this->table);

        // echo $this->db->last_query();
        return $this->db->count_all_results();
    }




    /*----------------------------------------
                    custome
    -----------------------------------------*/

    public function _get_datatables_queryCustom()
    {

        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }
        $tags = $info['filter_tags'];

        $id = $this->session->userdata('id');

		$getClient = $this->Clients->getCrawlerToClientUserId($id);
		$getMulticrawlers = $this->getCrawlersUnderClient($getClient);
        $users = array_column($getMulticrawlers, 'crawler_id');

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
        $abc =  join(",", $users);
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


    public function get_datatablesCustom($length, $start)
    {
        $str =  $this->_get_datatables_queryCustom();
        if ($length != -1)
            $str .= "Limit " . $start . "," . $length;
            $this->db->order_by('fb_request_date', 'DESC');

        $result = $this->db->query($str)->result();
        return  $result;
    }
    public function count_allForCustom()
    {
        $str = $this->_get_datatables_queryCustom();
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
            Crawler Recommendation End
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

    public function getCrawlerUserInfo($id, $sort = 0)
    {
        $this->db->select('id,full_name');
        $this->db->from('users');
        $this->db->where_in("id", $id);

        if ($sort == 1) {
            // echo "asc"; die();
            $this->db->order_by("full_name", 'ASC');
        }
        if ($sort == 2) {
            // echo "dsc"; die();
            $this->db->order_by("full_name", 'DESC');
        }


        $query_result = $this->db->get();
        $result = $query_result->result();
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

    public function getFacebookGroupsSearchResults($crawlerId, $searchText, $sort = 0)
    {
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where_in('crawler_id', $crawlerId);
        $this->db->like('fb_group_name', $searchText);

        if ($sort == 1) {
            $this->db->order_by("fb_group_name", 'ASC');
        }
        if ($sort == 2) {
            $this->db->order_by("fb_group_name", 'DESC');
        }

        $query_result = $this->db->get();
        $result = $query_result->result_array();

        // echo $this->db->last_query();
        return $result;
    }

    public function previousPeriodCountAllRecommendationsByFilter($lastPeriod_from, $lastPeriod_to, $groupId)
    {
        $this->db->select('COUNT(recommendations.fb_group_id) as groupIds');
        // $this->db->select('COUNT(id) as ids,fb_group_id');
        $this->db->from('recommendations');
        $this->db->join('groups', 'recommendations.fb_group_id = groups.fb_group_id');
        $this->db->where('recommendations.fb_request_date >=', $lastPeriod_from);
        $this->db->where('recommendations.fb_request_date <=', $lastPeriod_to);

        $this->db->where('recommendations.fb_group_id =', $groupId);

        $this->db->group_by('recommendations.fb_group_id');
        $this->db->order_by("recommendations.id", "asc");
        $query_result = $this->db->get();
        $result = $query_result->row_array();

        // echo $this->db->last_query();
        // die();
        return $result;
    }


}
