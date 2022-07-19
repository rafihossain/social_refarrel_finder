<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recommendations extends CI_Model
{
    var $table = 'recommendations';
    var $column_order = array(null, 'user_id', 'fb_request_full_name', 'fb_request_content', 'fb_group_id', 'fb_post_id', 'fb_request_date', 'source', 'tags'); //set column field database for datatable orderable
    var $column_search = array('fb_request_full_name', 'tags', 'source'); //set column field database for datatable searchable 
    // var $order = array('id' => 'asc'); // default order 
    var $order = array('fb_request_date' => 'DESC'); // default order 

    function __construct()
    {
        parent::__construct();
    }


    public function getMyTags($id)
    {
        $this->db->select('*');
        $this->db->from('tags');
        $this->db->where('crawler_id', $id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    
        public function getAllTags()
    {
        $this->db->select('tag');
        $this->db->from('tags');
       // $this->db->where('crawler_id', $id);
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        $tags = array_column($result, 'tag');
        return $tags;
    }
    
    
    public function amd_idClientInfo($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $id);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }


    public function amd_id()
    {
        $this->db->select('user_id');
        $this->db->from('ambassador_match');
        $this->db->where("ambassador_id", $this->session->userdata('id'));
        $query_result = $this->db->get();
        $result = $query_result->result();

        $allClintes  = [];
        if (count($result) > 0) {
            $id = $result[0]->user_id;
        } else {
            $allClintes  = [];
            $id = 0;
        }
        return $id;
    }

    private function _get_datatables_query($values)
    {


        //  
        //$allClintes = $this->Ambassadormodel->getAllAmbsclient($abc['id']);

        // $id = $this->amd_id();

        // if ($this->session->userdata('myClient')  != NULL) {
        //     $id =  $this->session->userdata('myClient');
        // }
        // echo  $id;die();

        //  $id = $this->session->userdata('id');

        // $this->db->order_by('fb_request_date', 'DESC');
        $this->db->where_in('user_id', $values);
        if ($this->input->post('filter_tags')[0] == 0) {
        } elseif ($this->input->post('filter_tags')[0] == 1) {
            $this->db->where('tags !=', '');
            $this->db->where('tags !=', null);
        } elseif ($this->input->post('filter_tags')[0] == 2) {
            $this->db->where('tags', '');
        } elseif ($this->input->post('filter_tags')[0] == 4) {
            $this->db->where('tags !=', '');
            $this->db->where('tags !=', null);

            $aaa = $this->input->post('filter_tags');
            unset($aaa[0]);

            foreach ($aaa as $aa) {
                $this->db->or_like('tags', $aa);
            }
        }

        if ($this->input->post('datepicker_from') != '') {

            $this->db->where('fb_request_date >=',  $this->input->post('datepicker_from') . ' 00:00:00');
        } else {

            $this->db->where('fb_request_date >=',  date("Y-m-d") . ' 00:00:00');
        }
        if ($this->input->post('datepicker_to') != '') {

            $this->db->where('fb_request_date <=',  $this->input->post('datepicker_to') . ' 23:59:59');
        } else {
            $this->db->where('fb_request_date <=',   date("Y-m-d") . ' 23:59:59');
        }
        //  echo 232332;die();

        //   echo  $this->db->where;die();


        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($data)
    {
        $this->_get_datatables_query($data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        return $query->result();
    }

    public function count_filtered($id)
    {
        $this->_get_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($userId)
    {
        $ids = 0;
        if ($this->session->userdata('account_level') == 'ambassador') {
            $id = $this->session->userdata('id');
            $query = $this->db->query("SELECT ambassador_match.user_id,ambassador_match.ambassador_id, users.full_name FROM ambassador_match INNER JOIN users ON ambassador_match.user_id=users.id where ambassador_match.ambassador_id =" . $this->session->userdata('id'));
            $row = $query->result();

            if (count($row) > 0) {
                $newArray = array_map(function ($o) {
                    return is_object($o) ? $o->user_id : $o['user_id'];
                }, $row);
                // $ids = join(',',$newArray);
                $ids = $newArray;
            }
        }
        $this->db->where_in('user_id', $userId);
        $this->db->from($this->table);
        return $this->db->count_all_results();
        // echo $this->db->last_query();
        // die();
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

    public function getkeyWordForRecommand($keyword_id)
    {

        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where('id', $keyword_id);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }
}
