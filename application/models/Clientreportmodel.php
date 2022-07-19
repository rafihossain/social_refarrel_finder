<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clientreportmodel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getAllClients()
    {
        $this->db->select('*');
        $this->db->from('users');
        //  $this->db->where("active",1);
        // $this->db->join('ambassador_reports', 'users.id = ambassador_reports.user_id', 'left');
        $this->db->where("account_level", 'client');
        $this->db->order_by('full_name', 'ASC');
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query(); 

        return $result;
    }
    public function getAllTagLists()
    {
        $this->db->select('*');
        $this->db->from('tag_lists');
        // $this->db->where("active",1);
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function getEndClientTag()
    {
        $this->db->select('*');
        $this->db->from('end_clients');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


    public function getclinetInfo($id)
    {
        //  echo $id;die();
        $this->db->select('full_name');
        $this->db->from('users');
        $this->db->where("id", $id);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }


    public function viewTableReport()
    {
        // $this->db->select('client_pdfs.*,end_clients.end_client, end_clients.product,end_clients.end_client_tag');
        $this->db->select('client_pdfs.*,end_client,end_client_tag,');
        $this->db->from('client_pdfs');
        $this->db->join('end_clients', 'client_pdfs.client = end_clients.end_client_id');
        $this->db->where("client_pdfs.active", 1);
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query(); 

        return $result;
    }

    public function clientPdf($pdfId)
    {
        $this->db->select('*');
        $this->db->from('client_pdfs');
        $this->db->join('end_clients', 'client_pdfs.client = end_clients.end_client_id');
        $this->db->where('client_pdfs.pdf_id', $pdfId);
        $query_result = $this->db->get();
        $result = $query_result->row();

        // echo $this->db->last_query(); 
        return $result;
    }

    public function getRecommendationsTag()
    {
        $this->db->select('*');
        $this->db->from('recommendations');
        $query_result = $this->db->get();
        $result = $query_result->result();

        // echo $this->db->last_query(); 

        return $result;
    }

    //new model
    public function groupsMonitored($crawlerId)
    {
        $this->db->select('id');
        $this->db->from('groups');
        $this->db->where('crawler_id', $crawlerId);
        $this->db->where('connected', 1);
        $result = $this->db->get();
        return $result->num_rows();

        // echo $this->db->last_query();
    }

    public function postsReviewed($dateFrom, $dateTo)
    {
        $this->db->select('id');
        $this->db->from('recommendations');
        $this->db->where('tags is NOT NULL', NULL, FALSE);
        $this->db->where('fb_request_date >=', $dateFrom);
        $this->db->where('fb_request_date <=', $dateTo);
        $query_result = $this->db->get();

        // echo $this->db->last_query();
        return $query_result->num_rows();
    }

    public function commentsReviewed($dateFrom, $dateTo)
    {
        $this->db->select('id');
        $this->db->from('recommendations');
        $this->db->like('tags', 'recommended');
        $this->db->or_like('tags', 'customer-service');
        $this->db->where('fb_request_date >=', $dateFrom);
        $this->db->where('fb_request_date <=', $dateTo);
        $query_result = $this->db->get();

        // echo $this->db->last_query();
        return $query_result->num_rows();
    }
    //new model end

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

    public function recommendationsIdByTagAndData()
    {
        $info = $this->input->post();
        $result = [];
        if ($info['account_id'] == '') {
            return $result;
        }
        $tags = explode(',', $info['client_tag']);
        $html = '';
        $i = 1;
        foreach ($tags as $tag) {

            $html .= " tags LIKE '%" . $tag . "%' ";

            if ($i != count($tags)) {
                $html .= " ESCAPE '!' OR ";
            }
            $i++;
        }

        $from = ($info['date_from'] != '' ? $info['date_from'] : date("Y-m-d"));
        $to = ($info['date_to'] != '' ? $info['date_to'] : date("Y-m-d"));
        $str = "SELECT id FROM `recommendations` WHERE (" . $html . ") AND `user_id` = '" . $info['account_id'] . "'  AND `fb_request_date` >= '" . $from . "' AND `fb_request_date` <= '" . $to . "' GROUP BY `id` ";
        $query_result = $this->db->query($str);
        return $query_result->num_rows();
    }


    public function recommendationsGroupByTagAndData()
    {
        $info = $this->input->post();
        $result = [];
        if ($info['account_id'] == '') {
            return $result;
        }
        $tags = explode(',', $info['client_tag']);
        $html = '';
        $i = 1;
        foreach ($tags as $tag) {

            $html .= " tags LIKE '%" . $tag . "%' ";

            if ($i != count($tags)) {
                $html .= " ESCAPE '!' OR ";
            }
            $i++;
        }

        $from = ($info['date_from'] != '' ? $info['date_from'] : date("Y-m-d"));
        $to = ($info['date_to'] != '' ? $info['date_to'] : date("Y-m-d"));


        $str = "SELECT fb_group_id FROM `recommendations` WHERE (" . $html . ") AND `user_id` = '" . $info['account_id'] . "'  AND `fb_request_date` >= '" . $from . "' AND `fb_request_date` <= '" . $to . "' GROUP BY `fb_group_id` ";
        $query_result = $this->db->query($str);
        //echo $this->db->last_query();die();
        return $query_result->num_rows();
    }

    public function recommendationstagWiseRequest($tag)
    {
        $info = $this->input->post();
        $from = ($info['date_from'] != '' ? $info['date_from'] : date("Y-m-d"));
        $to = ($info['date_to'] != '' ? $info['date_to'] : date("Y-m-d"));
        $str = "SELECT fb_group_id FROM `recommendations` WHERE tags LIKE '%" . $tag . "%' AND `user_id` = '" . $info['account_id'] . "'  AND `fb_request_date` >= '" . $from . "' AND `fb_request_date` <= '" . $to . "'";
        $query_result = $this->db->query($str);
        //echo $this->db->last_query();die();
        return $query_result->num_rows();
    }

    public function recommendationsGroupAndData()
    {
        $info = $this->input->post();
        $from = ($info['date_from'] != '' ? $info['date_from'] : date("Y-m-d"));
        $to = ($info['date_to'] != '' ? $info['date_to'] : date("Y-m-d"));
        $this->db->select('id');
        $this->db->from('recommendations');
        $this->db->where('user_id', $info['account_id']);
        $this->db->where('fb_request_date >=', $from);
        $this->db->where('fb_request_date <=', $to);
        $query_result = $this->db->get();
        return $query_result->num_rows();
    }

    public function all_requests_count()
    {
        $info = $this->input->post();
        $from = ($info['date_from'] != '' ? $info['date_from'] : date("Y-m-d"));
        $to = ($info['date_to'] != '' ? $info['date_to'] : date("Y-m-d"));
        $this->db->select('id');
        $this->db->from('recommendations');
        $this->db->where('user_id', $info['account_id']);
        $this->db->where('fb_request_date >=', $from);
        $this->db->where('fb_request_date <=', $to);
        $query_result = $this->db->get();
        return $query_result->num_rows();
    }

    public function recommendationsNonTagAndData()
    {
        $info = $this->input->post();
        $from = ($info['date_from'] != '' ? $info['date_from'] : date("Y-m-d"));
        $to = ($info['date_to'] != '' ? $info['date_to'] : date("Y-m-d"));
        $this->db->select('id');
        $this->db->from('recommendations');
        $this->db->where('user_id', $info['account_id']);
        $this->db->where('tags', '');
        $this->db->where('fb_request_date >=', $from);
        $this->db->where('fb_request_date <=', $to);
        $query_result = $this->db->get();
        return $query_result->num_rows();
    }

    public function multipleCrawlerl($id)
    {
        $this->db->select('crawler_id');
        $this->db->from('multiple_crawler');
        $this->db->join('client_pdfs', 'client_pdfs.client = multiple_crawler.end_client_id');
        $this->db->where('client_pdfs.pdf_id', $id);

        $query_result = $this->db->get();

        // echo $this->db->last_query(); 
        return $query_result->result();
    }
}
