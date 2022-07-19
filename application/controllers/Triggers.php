<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Triggers extends CI_Controller {
          public function __construct()
	{
	    // Call the CI_Model constructor
	    parent::__construct();
	    $this->load->model('User');
	    $this->load->model('Trigger');
		$this->load->helper('checkrequest');
		
		if(! $this->session->userdata('login_state')){
            return redirect(base_url());
        }
	   
	}


	public function index()
	{

	$data =[];
	$info = $this->input->post();
	
	$allReport['filtered_tags'] ='';
	$allReport['top_level_tag'] =0;
	$allReport['recommendations'] = [];
	$date =  date('Y-m-d');
	$new_date = date('Y-m-d', strtotime($date.' - 29 days'));

	$allReport['datepicker_from'] = $new_date;
	$allReport['datepicker_to'] = date('Y-m-d');
	$allReport['key_words']=[];
	if(count($info) > 0){
		$allReport['datepicker_from'] = $info['datepicker_from'];
		$allReport['datepicker_to'] = $info['datepicker_to'];
	


		$keys  =  $this->Trigger->getKeywords($info);
		$newdatas = [];
		foreach($keys as $nk){
			$mykeys = $this->Trigger->getKeyords($nk->keyword_id);
			if($nk->keyword_id != '' && $mykeys != '' ){
			$newdata = [];
			$newdata ['counts'] = $nk->ids;
			$newdata ['key_word'] = ($mykeys != '' ? $mykeys->keyword:'');
			$newdatas[] = $newdata;
		}
		}
	
		$allReport['key_words'] = $newdatas;
	}


	$data['full_content'] =  $this->load->view('trigger/index', $allReport, TRUE);
	$this->load->view('layout/master',$data);
	}
	// function getAllTags($tags){
	// 	if($tags =='' || $tags == null){
	// 	   return '';
	// 	}
	 
	// 	$tags =  explode(',',$tags);
	 
	// 	$html = '';
	//  foreach($tags as $tag){
	// 	if($tag !=''){
	// 	   $html .= "<span class='badge bg-primary'>" . $tag . "</span><span class='tag-comma'>, </span>";
	 
	// 	}
	//  }
	//  return $html;
	 
	//  }

	public function getTriggrtData(){

		//$list = $this->Trigger->get_datatables();
		// echo '<pre>';
		// print_r($list);
		// die();

//         $data = array();
//         $no = $_POST['start'];
		
// 		foreach ($list as $recommendation) {
//             $no++;
//             $row = array();
        
//            // $row[] = date('m/d/Y h:i A', strtotime($recommendation->fb_request_date));
//             $row[] = $recommendation->fb_request_full_name;
//             $row[] = $recommendation->fb_request_content;
//             // $row[] = $this->Reports->getkeyWord($recommendation->keyword_id);
//             // $row[] = $this->Reports->getFacebookGroup($recommendation->fb_group_id);
//             // $row[] = $recommendation->source;
//             // $row[] = $this->getAllTags($recommendation->tags);
 
//             $data[] = $row;
//         }

// 		// echo '<pre>';
// 		// print_r($list);
// 		// die();
// 		$output = array(
// 			"draw" => $_POST['draw'],
// 			"recordsTotal" => $this->Reports->count_all(),
// 			"recordsFiltered" => $this->Reports->count_filtered(),
// 			"data" => $data,
// 	);
// //output to json format
// echo json_encode($output);

	}

}