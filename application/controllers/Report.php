<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();

		$this->load->model('User');
		$this->load->model('Clients');
		$this->load->model('Crawler');
		$this->load->model('Reports');
		$this->load->model('Recommendations');
		$this->load->model('Ambassadormodel');
		$this->load->model('Clientonboardingmodel');

		$this->load->helper('download');

		$this->load->helper('checkrequest');
		$this->load->library("pagination");

		if (!$this->session->userdata('login_state')) {
			return redirect(base_url());
		}
	}

	public function index()
	{
		$data = [];
		$info = $this->input->post();
		$allReport['tags'] = $this->Reports->getAllTags();
		$allReport['crawlers'] = $this->Reports->getAllCrawlers();
		$allReport['filtered_tags'] = '';
		$allReport['top_level_tag'] = 0;
		$allReport['recommendations'] = [];
		$data['full_content'] =  $this->load->view('report/index', $allReport, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function selectedAccountAssociatedTag(){
		$info = $this->input->post();
		$results = $this->Reports->getSpecificTags($info['account_id']);
		
		if($results != ''){
			$data['success'] = $results;
		}else{
			$data['error'] = "Tag not found";
		}

		echo json_encode($data);

		
		// die();
		// echo "<pre>"; print_r($results); die();
	}

	public function getFilterDataFromOther()
	{
		$info = $this->input->post();
		if (count($info) > 0) {
			$this->session->set_userdata('searchInfo', $info);
		} else {
			$info = $this->session->userdata('searchInfo');
		}
		if ($info['filter_tags'][0] == 0 || $info['filter_tags'][0] == 1 || $info['filter_tags'][0] == 2 || $info['filter_tags'][0] == 3) {
			// echo "hi"; die();

			$config = array();
			$config["base_url"] = base_url() . "getreport";
			$config["total_rows"] = $this->Reports->count_all();

			// echo $this->db->last_query();
			// echo "<pre>"; print_r($config["total_rows"]); die();
			
			$config["per_page"] = 10;
			$config["uri_segment"] = 2;
			$config['attributes'] = array('class' => 'myclass');
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

			$filterData["links"] = $this->pagination->create_links();

			$list = $this->Reports->get_datatables($config["per_page"], $page);
			
			// echo $this->db->last_query();
			// echo "<pre>"; print_r($list); die();

			$data = [];
			foreach ($list as $recommendation) {
				//$no++;
				$row = array();

				$post_link = 'https://www.facebook.com/groups/' . $recommendation->fb_group_id . '/permalink/' . $recommendation->fb_post_id;

				$row['id'] = $recommendation->id;
				$row['date'] = date('m/d/Y h:i A', strtotime($recommendation->fb_request_date));
				$row['fb_request_full_name'] = '<div class="'.$recommendation->keyword_id.'">'.$recommendation->fb_request_full_name.'</div>';
				$row['fb_request_content'] = $recommendation->fb_request_content;
				$row['keyword_id'] = $this->Reports->getkeyWord($recommendation->keyword_id);
				$row['fb_group_id'] = $this->Reports->getFacebookGroup($recommendation->fb_group_id);
				$row['source'] = $recommendation->source;
				$row['tags'] = $this->getAllTags($recommendation->tags);
				$row['recmannded_reply'] = $this->recmanndedReply($recommendation->id, $recommendation->keyword_id, $post_link);

				$data[] = $row;
			}

			// $this->session->set_userdata();

			$filterData["reports"] = $data;
			// echo "<pre>"; print_r($filterData["reports"]); die();

			$htmldata[] = $this->load->view('report/alldata', $filterData, true);
			echo json_encode($htmldata);
		} else {
			// echo "hello"; die();

			$config = array();
			$config["base_url"] = base_url() . "getreport";
			$config["total_rows"] = $this->Reports->count_allForCustom();

			// echo $this->db->last_query();
			// echo "<pre>"; print_r($config["total_rows"]); die();

			$config["per_page"] = 10;
			$config["uri_segment"] = 2;
			$config['attributes'] = array('class' => 'myclass');
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

			$filterData["links"] = $this->pagination->create_links();

			$list = $this->Reports->get_datatablesCustom($config["per_page"], $page);
			// echo $this->db->last_query();
			// echo "<pre>"; print_r($list); die();

			$data = [];
			foreach ($list as $recommendation) {
				//$no++;
				$row = array();

				$post_link = 'https://www.facebook.com/groups/' . $recommendation->fb_group_id . '/permalink/' . $recommendation->fb_post_id;

				$row['id'] = $recommendation->id;
				$row['date'] = date('m/d/Y h:i A', strtotime($recommendation->fb_request_date));
				$row['fb_request_full_name'] ='<div class="'.$recommendation->keyword_id.'">'.$recommendation->fb_request_full_name.'</div>';
				$row['fb_request_content'] = $recommendation->fb_request_content;
				$row['keyword_id'] = $this->Reports->getkeyWord($recommendation->keyword_id);
				$row['fb_group_id'] = $this->Reports->getFacebookGroup($recommendation->fb_group_id);
				$row['source'] = $recommendation->source;
				$row['tags'] = $this->getAllTags($recommendation->tags);
				$row['recmannded_reply'] = $this->recmanndedReply($recommendation->id, $recommendation->keyword_id, $post_link);

				$data[] = $row;
			}
			// echo "<pre>"; print_r($data); die();

			$filterData["reports"] = $data;
			$htmldata[] = $this->load->view('report/alldata', $filterData, true);
			echo json_encode($htmldata);
		}
	}

	function LoadReportData()
	{
		// echo "hi"; die();

		$config = array();
		$config["base_url"] = base_url() . "load_report";
		$config["total_rows"] = $this->Reports->count_allReports();
		$config["per_page"] = 10;
		$config["uri_segment"] = 2;
		$config['attributes'] = array('class' => 'myclass');
		$this->pagination->initialize($config);

		// echo "<pre>";
        // print_r($config);
        // die();

		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

		$filterData["links"] = $this->pagination->create_links();
		
		$list = $this->Reports->getAllReportDataCustom($config["per_page"], $page);

		$data = [];
		foreach ($list as $recommendation) {
			//$no++;
			$row = array();

			$post_link = 'https://www.facebook.com/groups/' . $recommendation->fb_group_id . '/permalink/' . $recommendation->fb_post_id;

			$row['id'] = $recommendation->id;
			$row['date'] = date('m/d/Y h:i A', strtotime($recommendation->fb_request_date));
			$row['fb_request_full_name'] = $recommendation->fb_request_full_name;
			$row['fb_request_content'] = $recommendation->fb_request_content;
			$row['keyword_id'] = $this->Reports->getkeyWord($recommendation->keyword_id);
			$row['fb_group_id'] = $this->Reports->getFacebookGroup($recommendation->fb_group_id);
			$row['source'] = $recommendation->source;
			$row['tags'] = $this->getAllTags($recommendation->tags);
			$row['recmannded_reply'] = $this->recmanndedReply($recommendation->id, $recommendation->keyword_id, $post_link);

			$data[] = $row;
		}

		// echo "<pre>";
		// print_r($data);
		// die();


		$filterData["reports"] = $data;
		$htmldata[] = $this->load->view('report/alldata', $filterData, true);
		echo json_encode($htmldata);
	}

	/*============================================================
					Export To CSV
	==============================================================*/
	
	public function exportToCsv()
	{
		$info = $this->input->post();
		// echo "<pre>"; print_r($info); die();

		if (count($info) > 0) {
			$this->session->set_userdata('searchInfo', $info);
		} else {
			$info = $this->session->userdata('searchInfo');
		}
		if ($info['filter_tags'][0] == 0 || $info['filter_tags'][0] == 1 || $info['filter_tags'][0] == 2 || $info['filter_tags'][0] == 3) {
			// echo "hi"; die();

			$config = array();
			$config["base_url"] = base_url() . "getreport";
			$config["total_rows"] = $this->Reports->count_all();

			// echo $this->db->last_query();
			// echo "<pre>"; print_r($config["total_rows"]); die();
			
			$config["per_page"] = 10;
			$config["uri_segment"] = 2;
			$config['attributes'] = array('class' => 'myclass');
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

			$filterData["links"] = $this->pagination->create_links();

			$list = $this->Reports->get_datatables($config["per_page"], $page);
			
			// echo $this->db->last_query();
			// echo "<pre>"; print_r($list); die();

			$data = [];
			$i = 1;
			foreach ($list as $recommendation) {
				//$no++;
				$row = array();

				$post_link = 'https://www.facebook.com/groups/' . $recommendation->fb_group_id . '/permalink/' . $recommendation->fb_post_id;

				$row['id'] = $i;
				$row['date'] = date('m/d/Y h:i A', strtotime($recommendation->fb_request_date));
				$row['fb_request_full_name'] = $recommendation->fb_request_full_name;
				$row['fb_request_content'] = $recommendation->fb_request_content;
				$row['keyword_id'] = $this->Reports->getCSVKeyWord($recommendation->keyword_id);
				$row['fb_group_id'] = $this->Reports->getCSVFacebookGroup($recommendation->fb_group_id);
				$row['source'] = $recommendation->source;
				$row['tags'] = $recommendation->tags;
				// $row['recmannded_reply'] = $this->recmanndedReply($recommendation->id, $recommendation->keyword_id, $post_link);

				$data[] = $row;
				
				$i++;
			}

			// echo "<pre>"; print_r($list); die();

			$fp = fopen('file.csv', 'w'); 

			$header = ['SL No', 'Date', 'Full Name', 'Request Content', 'Keyword Name', 'Group Name', 'Source', 'Tags Name'];
			fputcsv($fp, $header);

			foreach ($data as $result) {
				fputcsv($fp, $result);
			}
			fclose($fp);

			$content = file_get_contents('file.csv');
			force_download('somthing.csv', $content);
			die();

			
		} else {
			$config = array();
			$config["base_url"] = base_url() . "getreport";
			$config["total_rows"] = $this->Reports->count_allForCustom();

			// echo $this->db->last_query();
			// echo "<pre>"; print_r($config["total_rows"]); die();

			$config["per_page"] = 10;
			$config["uri_segment"] = 2;
			$config['attributes'] = array('class' => 'myclass');
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

			$filterData["links"] = $this->pagination->create_links();

			$list = $this->Reports->get_datatablesCustom($config["per_page"], $page);
			// echo $this->db->last_query();
			// echo "<pre>"; print_r($list); die();

			$data = [];
			$i = 1;
			foreach ($list as $recommendation) {
				//$no++;
				$row = array();

				$post_link = 'https://www.facebook.com/groups/' . $recommendation->fb_group_id . '/permalink/' . $recommendation->fb_post_id;

				$row['id'] = $i;
				$row['date'] = date('m/d/Y h:i A', strtotime($recommendation->fb_request_date));
				$row['fb_request_full_name'] = $recommendation->fb_request_full_name;
				$row['fb_request_content'] = $recommendation->fb_request_content;
				$row['keyword_id'] = $this->Reports->getCSVKeyWord($recommendation->keyword_id);
				$row['fb_group_id'] = $this->Reports->getCSVFacebookGroup($recommendation->fb_group_id);
				$row['source'] = $recommendation->source;
				$row['tags'] = $recommendation->tags;
				// $row['recmannded_reply'] = $this->recmanndedReply($recommendation->id, $recommendation->keyword_id, $post_link);

				$data[] = $row;
				
				$i++;
			}
			// echo "<pre>"; print_r($data); die();

			$fp = fopen('file.csv', 'w'); 

			$header = ['SL No', 'Date', 'Full Name', 'Request Content', 'Keyword Name', 'Group Name', 'Source', 'Tags Name'];
			fputcsv($fp, $header);

			foreach ($data as $result) {
				fputcsv($fp, $result);
			}
			fclose($fp);

			$content = file_get_contents('file.csv');
			force_download('somthing.csv', $content);
			die();
		}
	}


	function exportToCsvCustom()
	{
		// echo "hi"; die();

		$data = $this->Reports->csv_customCount();
		$x = $data->total;
		$y = ceil($x / 200);
		// echo "<pre>"; print_r($division); die();

		$myarray = [];
		$newarray = [];
		// echo $x; die();
		for($i = 0; $i < 5; $i++){
				$abc = $i*200;
				$newarray = $this->Reports->getAllExportReportDataCustom($abc);
				sleep(1);
			$myarray = array_merge($myarray, $newarray);
		}
		
		$resultdata = $this->storeCSVData($myarray);
		
		$fp = fopen('file.csv', 'w'); 

		$header = ['SL No', 'Date', 'Full Name', 'Request Content', 'Keyword Name', 'Group Name', 'Source', 'Tags Name'];
		fputcsv($fp, $header);

		foreach ($resultdata as $result) {
			fputcsv($fp, $result);
		}
		fclose($fp);

		$content = file_get_contents('file.csv');
		force_download('somthing.csv', $content);
		die();
	}

	public function storeCSVData($list){
		
		$data = [];
		$i = 1;
		foreach ($list as $recommendation) {
			//$no++;
			$row = array();

			$post_link = 'https://www.facebook.com/groups/' . $recommendation->fb_group_id . '/permalink/' . $recommendation->fb_post_id;

			$row['id'] = $i;
			$row['date'] = date('m/d/Y h:i A', strtotime($recommendation->fb_request_date));
			$row['fb_request_full_name'] = $recommendation->fb_request_full_name;
			$row['fb_request_content'] = $recommendation->fb_request_content;
			$row['keyword_id'] = $this->Reports->getCSVKeyWord($recommendation->keyword_id);
			$row['fb_group_id'] = $this->Reports->getCSVFacebookGroup($recommendation->fb_group_id);
			$row['source'] = $recommendation->source;
			$row['tags'] = $recommendation->tags;
			// $row['recmannded_reply'] = $this->recmanndedReply($recommendation->id, $recommendation->keyword_id, $post_link);

			$data[] = $row;
			$i++;
		}

		return $data;
	}

	function getAllTags($tags)
	{
		// print_r($tags); die();

		if ($tags == '' || $tags == null) {
			return '';
		}

		$tags =  explode(',', $tags);

		$html = '';
		foreach ($tags as $tag) {
			if ($tag != '') {
				$html .= "<span class='me-2 bg-light  btn btn-sm rounded-pill'>" . $tag . "</span><span class='tag-comma'>, </span>";
			}
		}
		return $html;
	}

	public function recmanndedReply($id, $key_id, $post_link)
    {
        $keywords = $this->Recommendations->getkeyWordForRecommand($key_id);
		// echo $id; die();

        return [
            'id' => $id,
            'keywords' => $keywords,
            'post_link' => $post_link,
        ];
    }

	public function updateClientTag(){
        
		$info = $this->input->post();
		
		if(array_key_exists('tags', $info)){
			$tags = join(',',$info['tags']);
			$rm_id = $info['rm_id'];
			$abc = $this->Clients->updateData('recommendations',['tags'=> $tags],'id', $rm_id);
		}else{
			$tags = null;
			$rm_id = $info['rm_id'];
			$abc = $this->Clients->updateData('recommendations',['tags'=> $tags],'id', $rm_id);
		}

		$respon =  $this->getAllTags($tags) .'<a href="javascript:void(0)" onclick="show_modal_tags('. $rm_id.')"></a ';
		echo $respon;die();
    }

	public function getFilterData()
	{

		$list = $this->Reports->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $recommendation) {
			$no++;
			$row = array();

			$row[] = date('m/d/Y h:i A', strtotime($recommendation->fb_request_date));
			$row[] = $recommendation->fb_request_full_name;
			$row[] = $recommendation->fb_request_content;
			$row[] = $this->Reports->getkeyWord($recommendation->keyword_id);
			$row[] = $this->Reports->getFacebookGroup($recommendation->fb_group_id);
			$row[] = $recommendation->source;
			$row[] = $this->getAllTags($recommendation->tags);

			$data[] = $row;
		}

		// echo '<pre>';
		// print_r($list);
		// die();
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Reports->count_all(),
			"recordsFiltered" => $this->Reports->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
}
