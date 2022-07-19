<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends CI_Model
{
    var $table = 'recommendations';
    var $column_order = array(null, 'user_id', 'fb_request_full_name', 'fb_request_content', 'fb_group_id', 'fb_post_id', 'fb_request_date', 'source', 'tags'); //set column field database for datatable orderable
    var $column_search = array('fb_request_full_name', 'tags', 'source'); //set column field database for datatable searchable 
    var $order = array('id' => 'asc'); // default order 

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllTags()
    {
        $this->db->select('*');
        $this->db->from('tags');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function getSpecificTags($crawlerId)
    {
        $this->db->select('*');
        $this->db->from('tags');
        $this->db->where('crawler_id', $crawlerId);
        $query_result = $this->db->get();
        $result = $query_result->row();

        // echo $this->db->last_query();
        return $result;
    }

    public function getAllCrawlers()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('account_level', 'client');
        $this->db->where('active', 1);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


    public function getKeyWordIdBytext()
    {

        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }

        if ($info['exact_match'] == 1) {
            $text = explode(',', $info['txtTriggers']);
        }
        $cl = $info['crawler_account_id'];

        if ($cl != null) {
            //$this->db->where_in('crawler_id', $info['crawler_account_id']);
        }
        $this->db->where_in('keyword', $text);
        $this->db->select('id');
        $this->db->from('keywords');
        $query_result = $this->db->get();

        // echo $this->db->last_query();
        // die();

        $result = $query_result->result_array();
        $ids = [];
        if (count($result) > 0) {
            $ids = array_column($result, 'id');
        }

        return  $ids;
    }

    public function filterRecommendationById($getkewordId)
    {
        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }

        $this->db->select('id');
        $this->db->from('recommendations');
        $this->db->where_in('keyword_id', $getkewordId);
        
        $cl = $info['crawler_account_id'];

        if ($cl != null) {
            $this->db->where_in('user_id', $info['crawler_account_id']);
        }

        $query_result = $this->db->get();

        echo $this->db->last_query();
        // die();

        $result = $query_result->result_array();
        $ids = [];
        if (count($result) > 0) {
            $ids = array_column($result, 'id');
        }

        return  $ids;
    }

    public function getallClientIdByCrawler($ids)
    {
        // echo 3224;die();
        $this->db->where_in('crawler_id', $ids);
        $this->db->select('end_client_id');
        $this->db->from('multiple_crawler');
        $this->db->group_by('end_client_id');
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        $ids = [];
        if (count($result) > 0) {
            $ids = array_column($result, 'end_client_id');
        }

        return $ids;
    }


    private function _get_datatables_query()
    {


        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }
        $allids = $info['crawler_account_id'];
        $cl = $info['crawler_account_id'];
        if ($cl != null) {

            $client_sid = $this->getallClientIdByCrawler($info['crawler_account_id']);
            if (!empty($client_sid)) {
                $allids = array_unique(array_merge($client_sid, $info['crawler_account_id']));
            }
        }


        if ($info['txtTriggers'] != '') {
            $getkewordId =  $this->getKeyWordIdBytext();
            // echo "<pre>"; print_r($getkewordId); die();
            
            if(count($getkewordId) == ''){
                $this->db->like('recommendations.fb_request_content', $info['txtTriggers']); 
                $this->db->or_like('recommendations.fb_request_full_name', $info['txtTriggers']);
            }
            else{
                $this->db->where_in('keyword_id', $getkewordId);
                $this->db->or_like('recommendations.fb_request_content', $info['txtTriggers']); 
                $this->db->or_like('recommendations.fb_request_full_name', $info['txtTriggers']);
            }
            
            // $filterRecom = $this->filterRecommendationById($getkewordId);

            // $uniqueResults = array_unique(array_merge($getkewordId, $filterRecom));
            // echo "<pre>"; print_r($uniqueResults); die();
            
            
            
        }

        $this->db->where_in('user_id', $allids);
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

        // echo $this->db->last_query();
        // die();

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
        // echo $this->db->last_query();
        // die();
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

        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }

        $allids = $info['crawler_account_id'];
        $cl = $info['crawler_account_id'];
        if ($cl != null) {

            $client_sid = $this->getallClientIdByCrawler($info['crawler_account_id']);
            if (!empty($client_sid)) {
                $allids = array_unique(array_merge($client_sid, $info['crawler_account_id']));
            }
        }

        if ($info['txtTriggers'] != '') {
            $getkewordId =  $this->getKeyWordIdBytext();

            if(count($getkewordId) == ''){
                //  echo 11; die();
                $this->db->like('recommendations.fb_request_content', $info['txtTriggers']); 
            }else{
                // echo 22; die();
                $this->db->where_in('keyword_id', $getkewordId); 
            }
        }

        $this->db->where_in('user_id', $allids);
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
        // $this->db->from($this->table);
        $this->db->from($this->table);

        return $this->db->count_all_results();
    }

    public function getkeyWord($keyword_id)
    {
        $this->db->reset_query();

        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where('id', $keyword_id);
        $query_result = $this->db->get();

        // echo $this->db->last_query(); die();

        $result = $query_result->row();

        if ($result) {
            $str =  "<span class='me-2'>" . $result->keyword . "</span><span class='tag-comma'>, </span>";
            return $str;
        }

        return '';
    }

    public function getCSVKeyWord($keyword_id)
    {
        $this->db->reset_query();

        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where('id', $keyword_id);
        $query_result = $this->db->get();

        // echo $this->db->last_query(); die();

        $result = $query_result->row();
        return $result->keyword;
    }


    public function getFacebookGroup($group_id)
    {

        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where('fb_group_id', $group_id);
        $query_result = $this->db->get();
        $result = $query_result->row();
        if ($result) {
            $str =  "<a class='link-primary' target='_blank' href='https://www.facebook.com/groups/" . $group_id . "'>" . $result->fb_group_name . "</a>";
            return $str;
        }

        return '';
    }

    public function getCSVFacebookGroup($group_id)
    {
        // echo $group_id; die();

        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where('fb_group_id', $group_id);
        $query_result = $this->db->get();
        
        $result = $query_result->row();
        // echo "<pre>"; print_r($result->fb_group_name); die();

        return $result->fb_group_name;
    }

    public function _get_datatables_queryCustom()
    {

        $info = $this->input->post();
        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }
        $tags = $info['filter_tags'];

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
        $abc =  join(",", $info['crawler_account_id']);


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

    public function count_allReports()
    {
        $this->db->select('*');
        $this->db->from('recommendations');
        $query_result = $this->db->get();
        $result = $query_result->num_rows();
        return $result;

        // echo $this->db->last_query();

        // $this->db->limit(200);
        // echo "<pre>";
        // print_r($result);
        // die();

    }
    public function csv_customCount()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('recommendations');
        $query_result = $this->db->get();
        
        // echo $this->db->last_query();

        $result = $query_result->row();
        return $result;

    }
    public function getAllReportDataCustom($limit, $start)
    {

        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->limit($limit, $start);
        $this->db->group_by('fb_request_full_name');
        $this->db->order_by('fb_request_date', 'DESC');
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query();
        return $result;
    }

    public function getAllExportReportDataCustom($start)
    {
        // echo $start; die();
        if($start == 0){
            $start = 1;
        }
        $this->db->select('*');
        $this->db->from('recommendations');
        $this->db->limit(200, $start);
        $this->db->group_by('fb_request_full_name');
        $this->db->order_by('fb_request_date', 'DESC');
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query();
        return $result;
    }


    // public function get_list_countries()
    // {
    //     $this->db->select('country');
    //     $this->db->from($this->table);
    //     $this->db->order_by('country','asc');
    //     $query = $this->db->get();
    //     $result = $query->result();

    //     $countries = array();
    //     foreach ($result as $row) 
    //     {
    //         $countries[] = $row->country;
    //     }
    //     return $countries;
    // }



}
