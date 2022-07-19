<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientonboarding extends CI_Controller
{ 
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('User');
		$this->load->model('Clients');
		$this->load->model('Crawler');
		$this->load->model('Reports');
		$this->load->model('Recommendations');
		$this->load->model('Ambassadormodel');
		$this->load->model('Clientonboardingmodel');

		if (!$this->session->userdata('login_state')) {
			return redirect(base_url());
		}
	}

	public function index()
	{
		$clients['allClinets'] = $this->Clients->getAllClient();
		$clients['crawlers'] = $this->Clients->getAllCrawler();
		$clients['teamMembers'] = $this->Clients->getAllTeamMember();
		$clients['timezones'] = $this->Crawler->getAllTimzones();

		$clients['suggested_keys'] = $this->Clientonboardingmodel->getAllSuggestedKeyword();

		// echo "<pre>"; print_r($clients); die();

		$this->load->view('auth/client-onboarding', $clients);
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

	/*======================================
        All Data Client Onboarding
    ======================================*/
	public function onboardingRegistration(){
		// echo "<pre>"; print_r($_POST); die();
		
		$info = $this->input->post();

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
				// echo "<pre>"; print_r($groups); die();
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
			$notification_type = $info['notification_type'];

			$insertKeyword = [
				'crawler_id' => $mcrawlers,
				'end_client_id' => $endClientLastId,
				// 'notification_type' => $notification_type,
				'notification_address' => $notification_address,
				'notification_interval' => $notification_interval,
				'notification_timezone' => $notification_timezone,
				'notification_starts' => $notification_starts,
				'notification_ends' => $notification_ends,
			];
			$this->Clients->insertData('notification_settings', $insertKeyword);
		}

		$this->session->set_flashdata('success', 'Client onboarding from has been added successfully.');
		// redirect(base_url() . 'client', 'refresh');
	}


}