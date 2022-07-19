<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ambassadorspanel extends CI_Controller
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
		$this->load->model('User');
		$this->load->model('Crawler');
		$this->load->model('Ambassadormodel');
		// $this->load->model('FriendList_Model');

	}

    public function set_current_user(){
    $info = $this->input->post();
    $this->session->set_userdata('myClient',$info['cid']);	
    echo 1;
    }

	public function addNotificationSettings($id){
		$info = $this->input->post();
			$this->form_validation->set_rules('notification_type','Notification Type','trim|required');
			$this->form_validation->set_rules('notification_address','Notification Address','trim|required');
			$this->form_validation->set_rules('notification_timezone','notification   Timezone','trim|required');
			$this->form_validation->set_rules('notification_starts','Notification Starts','trim|required');
			$this->form_validation->set_rules('notification_ends','Notification Ends','trim|required');
		
			if($this->form_validation->run() == false)
			{
			redirect(base_url() . 'trdstep', 'refresh');	
			}
			else
			{
				$info = $this->input->post();

				$info['crawler_id']=$id;	
				$this->Crawler->insertData('notification_settings',$info);
				$id = $this->session->userdata('id');
				$this->session->set_flashdata('sucess','Notification Setting has been added successfully.');
				redirect(base_url() . 'ambassadors_notification/'.$id, 'refresh');	
			}
	}


	public function deletenoti($id){

		$this->Crawler->deleteData('notification_settings','id',$id);
		$id = $this->session->userdata('id');
		$this->session->set_flashdata('error','Notification Setting has been Deleted successfully.');
		redirect(base_url() . 'ambassadors_notification/'.$id, 'refresh');	
	}

}