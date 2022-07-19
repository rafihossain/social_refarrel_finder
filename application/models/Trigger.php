<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Trigger extends CI_Model
{
    // var $table = 'recommendations';
    // var $column_order = array(null, 'id','fb_request_date'); //set column field database for datatable orderable
    // var $column_search = array('fb_request_full_name','tags','source'); //set column field database for datatable searchable 
    // var $order = array('id' => 'asc'); // default order 

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function getAllTags(){
        $this->db->select('*');
        $this->db->from('tags');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    public function getAllCrawlers(){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('account_level','client');
        $this->db->where('active',1);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


    public function getKeywords($info){
            $this->db->select('keyword_id, COUNT(id) as ids');
            $this->db->group_by('keyword_id'); 
            $this->db->order_by('keyword_id', 'asc'); 

            if($info['datepicker_from'] !=''){
                
                $this->db->where('fb_request_date >=',  $info['datepicker_from'].' 00:00:00');
            }else{
                $date =  date('Y-m-d');
                $new_date = date('Y-m-d', strtotime($date.' - 29 days'));
                $this->db->where('fb_request_date >=', $new_date .' 00:00:00');
            }
            if($info['datepicker_to'] !=''){
                
                $this->db->where('fb_request_date <=',  $info['datepicker_to'].' 23:59:59');
            }else{
                $this->db->where('fb_request_date <=',   date("Y-m-d").' 23:59:59');
            }
       
        $query_result = $this->db->get('recommendations');
        $result = $query_result->result();
        return $result;
    }


    public function getKeyords($keyword_id){

        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where('id',$keyword_id);
        $this->db->where('active',1);
        $this->db->where('keyword != ','');
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

        // private function _get_datatables_query()
        // {
             

        //     if($this->input->post('datepicker_from') !=''){
               
        //         $this->db->where('fb_request_date >=',  $this->input->post('datepicker_from').' 00:00:00');
        //     }else{

        //         $this->db->where('fb_request_date >=',  date("Y-m-d").' 00:00:00');
        //     }
        //     if($this->input->post('datepicker_to') !=''){
             
        //         $this->db->where('fb_request_date <=',  $this->input->post('datepicker_to').' 23:59:59');
        //     }else{
        //         $this->db->where('fb_request_date <=',   date("Y-m-d").' 23:59:59');
        //     }
         
     
        //     $this->db->from($this->table);
        //     $i = 0;
         
        //     foreach ($this->column_search as $item) // loop column 
        //     {
        //         if($_POST['search']['value']) // if datatable send POST for search
        //         {
                     
        //             if($i===0) // first loop
        //             {
        //                 $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
        //                 $this->db->like($item, $_POST['search']['value']);
        //             }
        //             else
        //             {
        //                 $this->db->or_like($item, $_POST['search']['value']);
        //             }
     
        //             if(count($this->column_search) - 1 == $i) //last loop
        //                 $this->db->group_end(); //close bracket
        //         }
        //         $i++;
        //     }
             
        //     if(isset($_POST['order'])) // here order processing
        //     {
        //         $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        //     } 
        //     else if(isset($this->order))
        //     {
        //         $order = $this->order;
        //         $this->db->order_by(key($order), $order[key($order)]);
        //     }

        //    // echo $this->db->last_query();die();
        // }
     
        // public function get_datatables()
        // {
        //     $this->_get_datatables_query();
        //     if($_POST['length'] != -1)
        //     $this->db->limit($_POST['length'], $_POST['start']);
        //     $query = $this->db->get();
        //     return $query->result();
        // }
     
        // public function count_filtered()
        // {
        //     $this->_get_datatables_query();
        //     $query = $this->db->get();
        //     return $query->num_rows();
        // }
     
        // public function count_all()
        // {
        //     $this->db->from($this->table);
        //     return $this->db->count_all_results();
        // }
     

        // public function getkeyWord($keyword_id){
            
        //     $this->db->select('*');
        //     $this->db->from('keywords');
        //     $this->db->where('id',$keyword_id);
        //     $query_result = $this->db->get();
        //     $result = $query_result->row();
        //     if($result){
        //         $str =  "<span class='badge bg-info'>" . $result->keyword . "</span><span class='tag-comma'>, </span>";
        //         return $str;
        //     }

        //     return '';
        // }
        // public function getFacebookGroup($group_id){
            
        //     $this->db->select('*');
        //     $this->db->from('groups');
        //     $this->db->where('fb_group_id',$group_id);
        //     $query_result = $this->db->get();
        //     $result = $query_result->row();
        //     if($result){
        //         $str =  "<a class='link-primary' target='_blank' href='https://www.facebook.com/groups/" . $group_id . "'>" . $result->fb_group_name . "</a>";
        //         return $str;
        //     }

        //     return '';
        // }




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