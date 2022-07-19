<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Notifications extends CI_Model
{
    var $table = 'notifications';
    var $column_order = array(null, 'user_id','notification_address','notification_content','notification_datetime'); //set column field database for datatable orderable
    var $column_search = array('notification_address'); //set column field database for datatable searchable 
    var $order = array('id' => 'asc'); // default order 
    function __construct()
    {
        parent::__construct();
    }

    public function getNotifications($info){
        $this->db->select('*');
        if($this->input->post('datepicker_from') !=''){
            
            $this->db->where('notification_datetime >=',  $this->input->post('datepicker_from').' 00:00:00');
        }else{
            $date =  date('Y-m-d');
            $new_date = date('Y-m-d', strtotime($date.' - 29 days'));
            $this->db->where('notification_datetime >=', $new_date .' 00:00:00');
        }
        if($this->input->post('datepicker_to') !=''){
            
            $this->db->where('notification_datetime <=',  $this->input->post('datepicker_to').' 23:59:59');
        }else{
            $this->db->where('notification_datetime <=',   date("Y-m-d").' 23:59:59');
        }
   
    $query_result = $this->db->get('notifications');
    $result = $query_result->result();
    return $result;
}
  

private function _get_datatables_query()
{
     
    if($this->input->post('datepicker_from') !=''){
            
        $this->db->where('notification_datetime >=',  $this->input->post('datepicker_from').' 00:00:00');
    }else{
        $date =  date('Y-m-d');
        $new_date = date('Y-m-d', strtotime($date.' - 29 days'));
        $this->db->where('notification_datetime >=', $new_date .' 00:00:00');
    }
    if($this->input->post('datepicker_to') !=''){
        
        $this->db->where('notification_datetime <=',  $this->input->post('datepicker_to').' 23:59:59');
    }else{
        $this->db->where('notification_datetime <=',   date("Y-m-d").' 23:59:59');
    }


    $this->db->from($this->table);

    $i = 0;
 
    foreach ($this->column_search as $item) // loop column 
    {
        if($_POST['search']['value']) // if datatable send POST for search
        {
             
            if($i===0) // first loop
            {
                $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                $this->db->like($item, $_POST['search']['value']);
            }
            else
            {
                $this->db->or_like($item, $_POST['search']['value']);
            }

            if(count($this->column_search) - 1 == $i) //last loop
                $this->db->group_end(); //close bracket
        }
        $i++;
    }
     
    if(isset($_POST['order'])) // here order processing
    {
        $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } 
    else if(isset($this->order))
    {
        $order = $this->order;
        $this->db->order_by(key($order), $order[key($order)]);
    }

   
}

public function get_datatables()
{
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
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
    $this->db->from($this->table);
    return $this->db->count_all_results();
}




}