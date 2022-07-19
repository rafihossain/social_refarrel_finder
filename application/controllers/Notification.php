<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {
          public function __construct()
	{
	    // Call the CI_Model constructor
	    parent::__construct();
	    $this->load->model('User');
	    $this->load->model('Notifications');
		$this->load->helper('checkrequest');
		
		if(! $this->session->userdata('login_state')){
            return redirect(base_url());
        }
	   
	}


	public function index()
	{

	$data =[];
	$info = $this->input->post();
	
	$notice['filtered_tags'] ='';
	$notice['top_level_tag'] =0;
	$notice['recommendations'] = [];
	$date =  date('Y-m-d');
	$new_date = date('Y-m-d', strtotime($date.' - 29 days'));
	$notice['datepicker_from'] = $new_date;
	$notice['datepicker_to'] = date('Y-m-d');
	$notice['notifications']=[];
	$data['full_content'] =  $this->load->view('notification/index', $notice, TRUE);
	$this->load->view('layout/master',$data);
	}
	


	public function getNotification(){

		$list = $this->Notifications->get_datatables();
        $data = array();
        $no = $_POST['start'];
		
		foreach ($list as $noti) {
            $no++;
            $row = array();
        
            $row[] = date('m/d/Y h:i A', strtotime($noti->notification_datetime));
            $row[] = $noti->user_id;
            $row[] = $noti->notification_address;
            $row[] = $noti->notification_content;
           
            $data[] = $row;
        }

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Notifications->count_all(),
			"recordsFiltered" => $this->Notifications->count_filtered(),
			"data" => $data,
	);
//output to json format
echo json_encode($output);

	}


}