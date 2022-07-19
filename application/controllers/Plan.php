<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plan extends CI_Controller
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	
		$this->load->model('Recommendations');
		$this->load->model('Plans');
		// $this->load->model('FriendList_Model');
		
		if(! $this->session->userdata('login_state')){
            return redirect(base_url());
        }

	}

    public function index(){
        $data =[];
        $info = $this->input->post();
        $id = $this->session->userdata('id');
        $plans['plans'] = $this->Plans->getAllPlans();
        $data['full_content'] =  $this->load->view('plan/index', $plans, TRUE);
        $this->load->view('layout/master',$data);
    }

    public function addPlan(){
        $data =[];
        $info = $this->input->post();

        $this->form_validation->set_rules('plan_name', 'Plane Name', 'trim|required');
		$this->form_validation->set_rules('plan_code', 'Plane Code', 'trim|required');
		$this->form_validation->set_rules('keywords_limit', 'keywords_limit', 'trim|required');
		$this->form_validation->set_rules('groups_limit', 'groups_limit', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('plan_error', 'Please Check Required Field');
			redirect(base_url() . 'plan', 'refresh');
		} else {
//    echo '<pre>';
//         print_r($info);
//         die();
        $id = 	$this->Plans->insertData('plans', $info);
        $this->session->set_flashdata('plan_sucess', 'plans has been delete successfully.');
        redirect(base_url() . 'plan', 'refresh');

        }

    }

    public function deleteplan($id){
     //   echo $id;
            $this->Plans->deleteData('plans','id',$id);
            echo 1;
    }


}