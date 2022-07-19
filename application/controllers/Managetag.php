<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Managetag extends CI_Controller
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->model('User');
        $this->load->model('Managetagmodel');
        
        if(! $this->session->userdata('login_state')){
            return redirect(base_url());
        }
    }


    public function index()
    {
        // echo "hi"; die();
        $data = [];
        $managetags['managetags'] = $this->Managetagmodel->getTagLists();
        $data['full_content'] =  $this->load->view('managetag/manage-tag', $managetags, TRUE);
        $this->load->view('layout/master', $data);
    }

    public function taglistAdd()
    {
        $info = $this->input->post();
        // echo "<pre>";
        // print_r($info);
        // die();

        $this->form_validation->set_rules('tag_name', 'Tag Name', 'trim|required');
        $this->form_validation->set_rules('tag_list', 'Tag List Name', 'trim|required');
        if ($this->form_validation->run() == false) {
            redirect(base_url() . 'managetag', 'refresh');
        } else {

            $tagName = $info['tag_name'];
            $tagList = $info['tag_list'];

            $data = [
                'tag_list_name' => $tagName,
                'tags' => $tagList,
            ];

            $this->Managetagmodel->insertData('tag_lists', $data);
            
            $this->session->set_flashdata('success', 'Tag has been added successfully.');
            redirect(base_url() . 'managetag', 'refresh');
        }
    }
    
    public function taglistDelete($id)
    {
        $this->Managetagmodel->deleteData('tag_lists', 'id', $id);

        $success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);
    }

}
