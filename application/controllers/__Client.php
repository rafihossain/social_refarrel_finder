<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
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
		
		$this->load->library("pagination");

		if (!$this->session->userdata('login_state')) {
			return redirect(base_url());
		}
	}

	public function index()
	{
		$data = [];
		$clients = [];
		$clients['allClinets'] = $this->Clients->getAllClient();
		$clients['crawlers'] = $this->Clients->getAllCrawler();
		$clients['teamMembers'] = $this->Clients->getAllTeamMember();
		$clients['timezones'] = $this->Crawler->getAllTimzones();
		$clients['suggested_keys'] = $this->Clientonboardingmodel->getAllSuggestedKeyword();

		// echo "<pre>"; print_r($clients); die();

		$data['full_content'] =  $this->load->view('client/index', $clients, TRUE);
		$this->load->view('layout/master', $data);
	}
	public function crawlerName()
	{
		$id = $this->input->post('crawlerVal');
		getAllCrawlerUnderClient($id, 1);
	}

	public function editclient($id)
	{
		$data = [];
		$clinet = [];
		$clinet['sclient'] = $this->Clients->getSingleClient($id);
		$clinet['allcrawlers'] = $this->Clients->getAllCrawlers();
		$clinet['relatedcrawlers'] = $this->Clients->getAllRelatedCrawler($id);

		$info = $this->input->post();
		if (count($info) > 0) {
			$this->form_validation->set_rules('business_name', 'Business Name', 'trim|required');
			$this->form_validation->set_rules('contact_name', 'Client Name', 'trim|required');
			$this->form_validation->set_rules('client_email', 'Email', 'trim|required|valid_email');
			if ($this->form_validation->run() == false) {
			} else {

			

				/*========insert into end_clients table======*/
				$allclients = $this->Clients->getSingleClient($id);
				$userId = $allclients->user_id;


				/*========insert into users table======*/
				$client_email = $info['client_email'];
				$dashboard_user = $info['dashboard_user'];
				$dashboard_pass = $info['dashboard_pass'];

				$guid = bin2hex(openssl_random_pseudo_bytes(16));
				$updateClient = [
					'email' => $client_email,
					'full_name' => $dashboard_user,
					'password' => md5($dashboard_pass),
					'unique_identifier' => $guid,
					'account_level' => 'client',
					'active' => 1
				];
				$this->Clients->updateData('users', $updateClient, 'id', $userId);


				$business_name = $info['business_name'];
				$contact_name = $info['contact_name'];
				$client_tag = $info['client_tag'];
				$updateEndClient = [
					'user_id' => $userId,
					'business_name' => $business_name,
					'client_email' => $client_email,
					'end_client' => $contact_name,
					'end_client_tag' => $client_tag,
					'active' => 1,
				];
				$this->Clients->updateData('end_clients', $updateEndClient, 'end_client_id', $id);


				$this->session->set_flashdata('success', 'Client information updated successfully.');
				redirect(base_url() . 'client', 'refresh');
			}
		}

		$data['full_content'] =  $this->load->view('client/editclient', $clinet, TRUE);
		$this->load->view('layout/master', $data);
	}


	public function crawlerChange()
	{
		$dropInfo = $this->input->post();

		$endClientId = $dropInfo['end_client_id'];
		$crawlerId = $dropInfo['crawler_id'];
		$action = $dropInfo['action'];

		if ($action == 'add') {
			$dataInsert = [
				'end_client_id' => $endClientId,
				'crawler_id' => $crawlerId,
			];
			$this->Clients->insertData('multiple_crawler', $dataInsert);
		} else {
			$this->Clients->deleteMultiCrawlersData($dropInfo);
		}
		echo 1;
	}

	public function clientFbGroupCsv()
	{

		if (isset($_FILES['enter_csv']['name'])) {
			$this->load->library('upload');
			$config['upload_path'] = FCPATH . 'main_assets/uploads/csv/';
			$config['allowed_types'] = 'csv';
			$config['file_name'] = rand(99, 9999) . $_FILES['enter_csv']['name'];

			$this->upload->initialize($config);

			if ($this->upload->do_upload('enter_csv')) {
				$uploadData = $this->upload->data();
				$fileName = $uploadData['file_name'];
				$handle = fopen(FCPATH . 'main_assets/uploads/csv/' . $fileName, "r");

				$i = 1;
				$groupsData = [];
				while ($row = fgetcsv($handle)) {
					if ($i != 1) {
						$groupsData[$i]['fb_group_name'] = $row[0];
						$groupsData[$i]['fb_group_uri'] = $row[1];
						$groupsData[$i]['group_category'] = $row[2];
						$groupsData[$i]['type'] = $row[3];
						$groupsData[$i]['join_status'] = $row[4];
					}
					$i++;
				}
				$groupsData = array_values($groupsData);
				// echo "<pre>";
				// print_r($test);
				// die();

				$this->session->set_userdata('client_groupsdata', $groupsData);
				// $this->session->set_flashdata('success', 'CSV uploaded successfully!');
				redirect(base_url() . 'client', 'refresh');
			} else {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('csv_error', $error);
			}

			// $data['full_content'] =  $this->load->view('crawlers/secondstep', $groupsData, TRUE);
			// $this->load->view('layout/master', $data);


		}
	}


	/*======================================
        All Data Client Onboarding
    ======================================*/
	public function onboardingRegistration(){
		// echo "<pre>"; print_r($_POST); die();
		
		$info = $this->input->post();
		// print_r($info['multiple_category']); die();

		$client_email = $info['client_email'];
		$dashboard_user = $info['dashboard_user'];
		$dashboard_pass = $info['dashboard_pass'];

		$guid = bin2hex(openssl_random_pseudo_bytes(16));
		$addClient = [
			'email' => $client_email,
			'full_name' => $dashboard_user,
			'password' => md5($dashboard_pass),
			'unique_identifier' => $guid,
			'account_level' => 'client',
			'active' => 1
		];
		// echo "<pre>"; print_r($addClient); die();
		$clientLastId = $this->Clients->insertData('users', $addClient);

		/*========insert into end_clients table======*/
		$business_name = $info['business_name'];
		$contact_name = $info['contact_name'];
		// $client_tag = $info['client_tag'];

		// $clientLastId = 0;
		$insertEndClient = [
			'user_id' => $clientLastId,
			'business_name' => $business_name,
			'client_email' => $client_email,
			'end_client' => $contact_name,
			// 'end_client_tag' => $client_tag,
			'active' => 1,
		];
		// echo "<pre>"; print_r($insertEndClient); die();
		$endClientLastId = $this->Clients->insertData('end_clients', $insertEndClient);

		$multi_crawlers = $info['multiple_category'];

		// $endClientLastId = 0;
		foreach ($multi_crawlers as $mcrawlers) {
			// echo "<pre>"; print_r($mcrawlers);
			$multiCrawlerInsert = [
				'end_client_id' => $endClientLastId,
				'crawler_id' => $mcrawlers,
			];
			$this->Clients->insertData('multiple_crawler', $multiCrawlerInsert);

			/*========insert into groups table======*/
			$groups = json_decode($info['group']);
			foreach ($groups as $group) {
				$group_url = str_replace("https://", "", $group->fb_group_uri);
				$group_url = str_replace("http://", "", $group_url);
				$group_url = str_replace("www.", "", $group_url);
				$group_url = str_replace("m.", "", $group_url);
				$group_url = str_replace("fb.com", "", $group_url);
				$group_url = str_replace("facebook.com", "", $group_url);
				$group_url = str_replace("groups", "", $group_url);
				$group_url = str_replace("/", "", $group_url);
				if (strpos($group_url, "?")) {
					$group_url = substr($group_url, 0, strpos($group_url, "?"));
				}

				$groups = [
					"crawler_id" => $mcrawlers,
					'end_client_id' => $endClientLastId,
					"fb_group_id" => $group_url,
					"fb_group_name" => str_replace("#", "", $group->fb_group_name),
					"group_category" => $group->group_category,
					"fb_group_uri" => "https://www.facebook.com/groups/" . $group_url,
					"type" => $group->type,
					"connected" => 1
				];
				$this->Clients->insertData('groups', $groups);
			}


			/*========insert into keyword table======*/
			$keywords = json_decode($info['keyword']);
			foreach ($keywords as $key) {
				$key_value = $key->keyword;
				$recommended_reply = $key->recommended_reply;
				$must_include_keywords = $key->must_include_keywords;
				$must_include_condition = $key->must_include_condition;
				$must_exclude_keywords = $key->must_exclude_keywords;

				$insertKeyword = [
					'crawler_id' => $mcrawlers,
					'end_client_id' => $endClientLastId,
					'keyword' => $key_value,
					'must_include_keywords' => $must_include_keywords,
					'must_include_condition' => $must_include_condition,
					'must_exclude_keywords' => $must_exclude_keywords,
					'recommended_reply' => $recommended_reply,
				];
				$this->Clients->insertData('keywords', $insertKeyword);
			}

			/*========insert into notification_settings table======*/
			$notification_address = $info['notification_address'];
			$notification_interval = $info['notification_interval'];
			$notification_timezone = $info['notification_timezone'];
			$notification_starts = $info['notification_starts'];
			$notification_ends = $info['notification_ends'];
			// $notification_type = $info['notification_type'];

			$insertNotification = [
				'crawler_id' => $mcrawlers,
				'end_client_id' => $endClientLastId,
				// 'notification_type' => $notification_type,
				'notification_address' => $notification_address,
				'notification_interval' => $notification_interval,
				'notification_timezone' => $notification_timezone,
				'notification_starts' => $notification_starts,
				'notification_ends' => $notification_ends,
			];
			$this->Clients->insertData('notification_settings', $insertNotification);
		}

		$this->session->set_flashdata('success', 'Client onboarding from has been added successfully.');
		redirect(base_url() . 'client', 'refresh');
	}
	


	public function deleteclient($id)
	{

		$this->Clients->deleteData('keywords', 'client_id', $id);
		$this->Clients->deleteData('end_clients', 'end_client_id', $id);

		$success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);
	}

	public function myTag()
	{
		$id = $this->session->userdata('id');
		$tag['tags'] = $this->Clients->getAllTag($id);
		$data['full_content'] =  $this->load->view('tags/index', $tag, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function addclienttags()
	{
		$info = $this->input->post();
		$this->form_validation->set_rules('tag', 'Tag', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', 'Tag Is Empty');
			redirect(base_url() . 'tags', 'refresh');
		} else {
			$info = $this->input->post();
			$info['crawler_id'] = $this->session->userdata('id');
			$this->Clients->insertData('tags', $info);
			$this->session->set_flashdata('sucess', 'Tag ' . $info['tag'] . ' has been added successfully.');
			redirect(base_url() . 'tags', 'refresh');
		}
	}

	public function deleteCrawlerTag($id)
	{
		$this->Clients->deleteData('tags', 'id', $id);
		$this->session->set_flashdata('sucess', 'Tag has been delete successfully.');
		redirect(base_url() . 'tags', 'refresh');
	}

    
    /*=======================================================================
                Client Recommendation Start
=========================================================================*/

	public function clientRemmendation()
	{
		// echo 12;die();
		$data = [];
		$id = $this->session->userdata('id');

		$allReport['tags'] = $this->Clients->getAllTag($id);
		$allReport['filtered_tags'] = '';
		$allReport['top_level_tag'] = 0;
		$allReport['recommendations'] = [];
		$data['full_content'] =  $this->load->view('recommendation/client_recommedation', $allReport, TRUE);
		$this->load->view('layout/master', $data);
	}


	public function getClientFilterData()
	{
		$config = array();
		$config["base_url"] = base_url() . "getclientrecommendation";
		$config["total_rows"] = $this->Clients->count_all();
		$config["per_page"] = 10;
		$config["uri_segment"] = 2;
		$config['attributes'] = array('class' => 'myclass');
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$filterData["links"] = $this->pagination->create_links();

		$list = $this->Clients->get_datatables($config["per_page"], $page);

		$data = array();
		foreach ($list as $recommendation) {
			$row = array();
			// if ($recommendation->fb_group_id  == "source") {
			$post_link = 'https://www.facebook.com/groups/' . $recommendation->fb_group_id . '/permalink/' . $recommendation->fb_post_id;
			// } else {
			// $post_link = 'https://nextdoor.com/news_feed/?post=' . $recommendation->fb_post_id;
			// }


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

		// echo "<pre>"; print_r($data); die();

		$filterData["reports"] = $data;

		$htmldata[] = $this->load->view('recommendation/reponse/crawler-response', $filterData, true);
		echo json_encode($htmldata);
	}

	function getAllTags($tags)
	{
		if ($tags == '' || $tags == null) {
			return '';
		}

		$tags =  explode(',', $tags);

		$html = '';
		foreach ($tags as $tag) {
			if ($tag != '') {
				$html .= '<span class="me-2 bg-light  btn btn-sm rounded-pill">' . $tag . '</span><span class="tag-comma">, </span>';
			}
		}
		return $html;
	}
	
	public function recmanndedReply($id, $key_id, $post_link)
    {
        $keywords = $this->Recommendations->getkeyWordForRecommand($key_id);

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
    
    
    

/*=======================================================================
                Client Recommendation End
=========================================================================*/


	public function clientgroups()
	{
		$id = $this->session->userdata('id');
		// echo "<pre>"; print_r($id); die();
		$group['groups'] = $this->Clients->getAllClientFacebookGroup($id);

		// $tag['tags'] = $this->Clients->getAllFacebookGroup($id);
		$data['full_content'] =  $this->load->view('groups/index', $group, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function clientAccount()
	{
		// $user_data['info'] = $this->Client->getAllUserAccount();
		$getId = $this->session->userdata('id');
		$getMulticrawlers = $this->Clients->getAllCrawlersUnderClient($getId);
        $id = array_column($getMulticrawlers, 'crawler_id');
		
		$user_data['clientinfo'] = $this->Crawler->getUserInfo($getId);
		$user_data['crawlerinfo'] = $this->Clients->getUserInfo($id);
		

		// $user_data['keywords'] = $this->Crawler->getMyKeyowrd($id);
		// $user_data['groups'] = $this->Crawler->getAllGroups($id);
		// $user_data['tags'] = $this->Crawler->getAllTags($id);

		$user_data['suggested_keys'] = $this->Clientonboardingmodel->getAllSuggestedKeyword();
		$user_data['timezones'] = $this->Crawler->getAllTimzones();

		// echo "<pre>";
		// print_r($user_data);
		// die();

		$data['full_content'] =  $this->load->view('client/account', $user_data, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function changePassword($id)
	{
		//echo $id;die();
		$info = $this->input->post();
		$oldpass =  md5($info['old_password']);
		$newpass =  md5($info['new_password']);

		$myinfo = $this->Crawler->getMyInfo($id, $oldpass);

		if ($myinfo == true) {
			$pass = ['password' => $newpass];
			$this->Crawler->updateData('users', $pass, 'id', $id);
			$this->session->set_flashdata('sucess', 'Password has been Update successfully.');
			redirect(base_url() . 'clientaccount', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Password Not Matched.');
			redirect(base_url() . 'clientaccount', 'refresh');
		}
	}

	public function addClientGroup()
	{

		$info = $this->input->post();
		$id = $this->session->userdata('id');


		$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
		$this->form_validation->set_rules('group_url', 'Group Url', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('group_error', 'Group name or Group url Is Empty');
			redirect(base_url() . 'editcrawler/' . $id, 'refresh');
		} else {

			$getMulticrawlers = $this->Clients->multiCrawlersInfoForClient($id);

			$info = $this->input->post();

			$group_url = str_replace("https://", "", $info['group_url']);
			$group_url = str_replace("http://", "", $group_url);
			$group_url = str_replace("www.", "", $group_url);
			$group_url = str_replace("m.", "", $group_url);
			$group_url = str_replace("fb.com", "", $group_url);
			$group_url = str_replace("facebook.com", "", $group_url);
			$group_url = str_replace("groups", "", $group_url);
			$group_url = str_replace("/", "", $group_url);
			if (strpos($group_url, "?")) {
				$group_url = substr($group_url, 0, strpos($group_url, "?"));
			}

			$groups = [];

			$groups = [
				"fb_group_id" => $group_url,
				"fb_group_name" => str_replace("#", "", $info['group_name']),
				"group_category" => $info['group_category'],
				"fb_group_uri" => "https://www.facebook.com/groups/" . $group_url,
				"type" => $info['type'],
				"connected" => $info['join_status']
			];


			for ($j = 0; $j < count($getMulticrawlers); $j++) {
				$groups['crawler_id']  =  $getMulticrawlers[$j];
				$groups['end_client_id'] = $id;

				$this->Crawler->insertData('groups', $groups);
			}

			$this->session->set_flashdata('group_sucess', 'Group has been added successfully.');
			redirect(base_url() . 'clientgroups', 'refresh');
		}
	}

	public function ClientDisconnectGroup($id)
	{
		//echo $id;die();
		$groups = ["connected" => 0];
		$gid = $this->Crawler->updateData('groups', $groups, 'id', $id);
		$this->session->set_flashdata('group_sucess', 'Group has been Disconnect successfully.');

		//redirect(base_url() . 'clientgroups', 'refresh');

		$success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);
	}
	public function clientKeywords()
	{
		$id = $this->session->userdata('id');
		$data = [];
		$clientUser = $this->Clients->getAllCrawlersUnderClient($id);
        //$getMulticrawlers = $this->Clients->getAllCrawlersUnderClient($id);
        
 
		foreach($clientUser as $user){
			$keys['keywords'] = $this->Clients->getMyAllKeywords($user['end_client_id']);
		
			
		}

		// echo $this->db->last_query();
		// echo '<pre>';
		// print_r($keys['keywords']);
		// die();

		$keys['cinfo'] = $this->Crawler->getClientsinfo($id);

		$data['full_content'] =  $this->load->view('keyword/index', $keys, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function clientRemoveKeywords($id)
	{

		//$groups= ["connected" => 0];
		$gid = $this->Clients->deleteData('keywords', 'id', $id);
		$this->session->set_flashdata('sucess', 'Keywords has been Delete successfully.');
		//redirect(base_url() . 'clientkeyword', 'refresh');

		$success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);
	}

	public function addClientKeywords()
	{
		$id = $this->session->userdata('id');

		$this->form_validation->set_rules('keyword', 'Keyword', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('group_error', 'Group name or Group url Is Empty');
			redirect(base_url() . 'clientkeyword', 'refresh');
		} else {
			$info = $this->input->post();

            //echo '<pre>';
            //print_r($info);
            //die();


			$multirecomreply = implode(',', $info['recommended_reply']);
		//	$getMulticrawlers = $this->Clients->multiCrawlersInfoForClient($id);
		$getMulticrawlers = $this->Clients->getAllCrawlersUnderClient($id);
		//	echo $this->db->last_query();
            //echo '<pre>';
          //  print_r($getMulticrawlers);
            //die();


			$key = [];
			$key['keyword'] = $info['keyword'];
			$key['recommended_reply'] = $multirecomreply;
			$key['must_include_keywords'] = $info['must_include_keywords'];
			$key['must_include_condition'] = $info['must_include_condition'];
			$key['must_exclude_keywords'] = $info['must_exclude_keywords'];

			for ($j = 0; $j < count($getMulticrawlers); $j++) {
				$key['crawler_id']  =  $getMulticrawlers[$j]['crawler_id'];
				$key['end_client_id'] = $getMulticrawlers[$j]['end_client_id'];
                $this->Crawler->insertData('keywords', $key);
               // echo $this->db->last_query();
			}

			$this->session->set_flashdata('sucess', 'keywords has been added successfully.');
			redirect(base_url() . 'clientkeyword', 'refresh');
		}
	}


	public function editClientkeyword($id)
	{
		$data = [];
		$uid = $this->session->userdata('id');
		$keys['keyword'] = $this->Clients->getSingleKeyword($id);
		$data['full_content'] =  $this->load->view('keyword/edit', $keys, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function updateClientkeyword($id)
	{
		$info = $this->input->post();

		$multirecomreply = implode(',', $info['recommended_reply']);
		$info['recommended_reply'] = $multirecomreply;

		$this->Crawler->updateData('keywords', $info, 'id', $id);

		// echo $this->db->last_query();

		// echo "<pre>";
		// print_r($info);
		// die();

		$this->session->set_flashdata('sucess', 'keywords has been update successfully.');
		redirect(base_url() . 'clientkeyword', 'refresh');
	}

	public function clientImage($id = 0)
	{
		$accountLevel = $this->session->userdata('account_level');
		if ($accountLevel != 'client') {
			$aid = $this->session->userdata('id');
		}
		// print_r($id); die();

		if (isset($_FILES['client_image']['name'])) {

			// Client Profile Image Upload
			$this->load->library('upload');

			$config['upload_path'] = FCPATH . 'main_assets/uploads/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['file_name'] = rand(99, 9999) . $_FILES['client_image']['name'];

			$this->upload->initialize($config);

			if ($this->upload->do_upload('client_image')) {
				$uploadData = $this->upload->data();
				$fileName = $uploadData['file_name'];

				$userUpdate = [
					'user_image' => $fileName
				];

				$this->User->updateData('users', $userUpdate, 'id', $id);
				$this->session->set_flashdata('success', 'Image upload successfully');

				if ($accountLevel == 'client') {
					return redirect(base_url() . 'clientaccount', 'refresh');
				} else {
					return redirect(base_url() . 'ambassadors_account/' . $aid, 'refresh');
				}
			} else {
				echo $this->upload->display_errors();
			}
		}
	}

	/*======================================
            Team Member Depand
            ======================================*/
	public function teammemberDepand($id)
	{
		$results = $this->Clients->teammemberDepand($id);
		// echo "<pre>";
		echo json_encode($results);
	}


	public function uploadKeywordCSv($id)
	{
		$getMulticrawlers = $this->Clients->getAllCrawlersUnderClient($id);

		if (isset($_FILES['enter_csv']['name'])) {
			$this->load->library('upload');
			$config['upload_path'] = FCPATH . 'main_assets/uploads/csv/';
			$config['allowed_types'] = 'csv';
			$config['file_name'] = rand(99, 9999) . $_FILES['enter_csv']['name'];

			$this->upload->initialize($config);

			if ($this->upload->do_upload('enter_csv')) {
				$uploadData = $this->upload->data();
				$fileName = $uploadData['file_name'];
				$handle = fopen(FCPATH . 'main_assets/uploads/csv/' . $fileName, "r");
				$i = 1;

				while ($row = fgetcsv($handle)) {

					if ($i != 1) {
						$key = [];
						$key['keyword'] = $row['0'];
						$key['must_include_keywords'] = $row['1'];
						$key['must_include_condition'] = $row['2'];
						$key['must_exclude_keywords'] = $row['3'];
						$key['recommended_reply'] = $row['4'];

						for ($j = 0; $j < count($getMulticrawlers); $j++) {
							$key['crawler_id']  =  $getMulticrawlers[$j]['crawler_id'];
							$key['end_client_id'] = $getMulticrawlers[$j]['end_client_id'];
							$this->Crawler->insertData('keywords', $key);

							// echo "<pre>";
							// print_r($key);
						}
					}
					$i++;
				}
				// echo "<pre>";
				// print_r($key);
				// die();

				$this->session->set_flashdata('success', 'CSV uploaded successfully!');
				redirect(base_url() . 'clientkeyword', 'refresh');
			} else {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('csv_error', $error);
				redirect(base_url() . 'clientkeyword', 'refresh');
			}
		}
		//	while ($row = fgetcsv($handle))
	}

	
	/*======================================
        All Data Client Profile
    ======================================*/
	public function clientProfile(){
		// echo "hi"; die();
		// echo "<pre>"; print_r($end_client_id); die();
		
		$end_client_id = $this->session->userdata('client_id');
		$info = $this->input->post();
		$multi_crawlers = $info['multiple_category'];

		// $endClientLastId = 0;
		foreach ($multi_crawlers as $mcrawlers) {

			/*========insert into groups table======*/
			$groups = json_decode($info['group']);
			foreach ($groups as $group) {
				$group_url = str_replace("https://", "", $group->fb_group_uri);
				$group_url = str_replace("http://", "", $group_url);
				$group_url = str_replace("www.", "", $group_url);
				$group_url = str_replace("m.", "", $group_url);
				$group_url = str_replace("fb.com", "", $group_url);
				$group_url = str_replace("facebook.com", "", $group_url);
				$group_url = str_replace("groups", "", $group_url);
				$group_url = str_replace("/", "", $group_url);
				if (strpos($group_url, "?")) {
					$group_url = substr($group_url, 0, strpos($group_url, "?"));
				}

				$groups = [
					"crawler_id" => $mcrawlers,
					"end_client_id" => $end_client_id,
					"fb_group_id" => $group_url,
					"fb_group_name" => str_replace("#", "", $group->fb_group_name),
					"group_category" => $group->group_category,
					"fb_group_uri" => "https://www.facebook.com/groups/" . $group_url,
					"type" => $group->type,
					"connected" => 1
				];

				$this->Clients->insertData('groups', $groups);

			}
			// die();


			/*========insert into keyword table======*/
			$keywords = json_decode($info['keyword']);
			foreach ($keywords as $key) {
				$key_value = $key->keyword;
				$recommended_reply = $key->recommended_reply;
				$must_include_keywords = $key->must_include_keywords;
				$must_include_condition = $key->must_include_condition;
				$must_exclude_keywords = $key->must_exclude_keywords;

				$insertKeyword = [
					'crawler_id' => $mcrawlers,
					"end_client_id" => $end_client_id,
					'keyword' => $key_value,
					'must_include_keywords' => $must_include_keywords,
					'must_include_condition' => $must_include_condition,
					'must_exclude_keywords' => $must_exclude_keywords,
					'recommended_reply' => $recommended_reply,
				];
				
				$this->Clients->insertData('keywords', $insertKeyword);
			}
			// die();

			/*========insert into notification_settings table======*/
			$notification_address = $info['notification_address'];
			$notification_interval = $info['notification_interval'];
			$notification_timezone = $info['notification_timezone'];
			$notification_starts = $info['notification_starts'];
			$notification_ends = $info['notification_ends'];
			// $notification_type = $info['notification_type'];

			$insertNotification = [
				'crawler_id' => $mcrawlers,
				"end_client_id" => $end_client_id,
				// 'notification_type' => $notification_type,
				'notification_address' => $notification_address,
				'notification_interval' => $notification_interval,
				'notification_timezone' => $notification_timezone,
				'notification_starts' => $notification_starts,
				'notification_ends' => $notification_ends,
			];
			
			$this->Clients->insertData('notification_settings', $insertNotification);
		}

		$this->session->set_flashdata('success', 'Client onboarding from has been added successfully.');
		// die();
		redirect(base_url() . 'clientaccount', 'refresh');
	}



	/*======================================
            Team Member Depand
    ======================================*/

	public function onboardingTeamDepand($id){
		$results = $this->Clientonboardingmodel->teammemberDepand($id);
		echo json_encode($results);
	}

	public function fbGroupCategory(){
		$info = $this->input->post();
		// echo "<pre>"; print_r($info); die();

		$getGroupId = $info['crawler_id'];
		$results = $this->Clientonboardingmodel->getFacebookGroupInformation($getGroupId);

		// echo "<pre>"; print_r($results); die();
		echo json_encode($results);
	}

	/*======================================
        fetch Client Onboarding Fb groups
    ======================================*/

	public function fetchClientOnboardingGroups(){
		$info = $this->input->post();
		// echo "<pre>"; print_r($info); die();

		if($info['action'] == 'add'){
			$onboardingmc = $info['crawler_id'];
			for($i = 0; $i < count($onboardingmc); $i++){
				$onboardingGroups = [
					'crawler_picked' => $onboardingmc[$i],
					'fb_groups' => $info['group_id'] 
				];
				$this->Clientonboardingmodel->insertData('clientonboarding_fbgroups',$onboardingGroups);
			}
			// die();

			$fbGroupsIdUpdate = [
				'status' => 1 
			];
			
			$this->Clientonboardingmodel->updateData('groups', $fbGroupsIdUpdate, 'id', $info['group_id'] );
			
			$cgroupInfo = $this->Clientonboardingmodel->getCrawlerGroupInformation($onboardingmc, $info['group_id']);
			// echo "<pre>"; print_r($cgroupInfo); die();
			
			$results = [
				'cgroupinfo' => $cgroupInfo,
				'action' => $info['action'],
			];
			echo json_encode($results);
		}else{
			$onboardingmc = $info['crawler_id'];
			$this->Clientonboardingmodel->deleteData('clientonboarding_fbgroups', 'fb_groups', $info['group_id'] );
			// echo $this->db->last_query(); die();
			$fbGroupsIdUpdate = [
				'status' => 0 
			];

			$result = $this->Clientonboardingmodel->updateData('groups', $fbGroupsIdUpdate, 'id', $info['group_id'] );
			
			$results = [
				'cgroupinfo' => $result,
				'action' => $info['action'],
			];
			echo json_encode($results);
		}

	}

}
