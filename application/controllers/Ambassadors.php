<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ambassadors extends CI_Controller
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
		$this->load->model('User');
		$this->load->model('Ambassadormodel');
		$this->load->model('Crawler');
		$this->load->model('Clients');
		$this->load->model('Reports');
		$this->load->model('Recommendations');
		$this->load->model('Clientonboardingmodel');
		// $this->load->model('FriendList_Model');
	}
	public function index()
	{
		$data = [];
		$ambassadors = $this->Ambassadormodel->getAmbassadors();
		foreach($ambassadors as $amb){		
			$amb->clients =  $this->Ambassadormodel->getAllAmbsclient($amb->id);
			$amb->reports =  $this->Ambassadormodel->getAllReports($amb->id);
			$ambassadors['ambassadors'][]= $amb;
		}
		$ambassadors['clients']=$this->Ambassadormodel->getAllClients();

		// echo "<pre>";
		// print_r($ambassadors);
		// die();

		$data['full_content'] =  $this->load->view('ambassadors/index', $ambassadors, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function ambassadorsReport()
	{
		$info = $this->input->post();
		$report = $this->Ambassadormodel->getAllReports($info['ambassador_id']);

		if($report == null){
			$reportsUpdate = [
				'user_id' => $info['ambassador_id'],
				'daily_progress' => 0,
				'weekly_progress' => 0,
				'pick_it_up' => 0,
			];
			$this->Ambassadormodel->insertData('ambassador_reports',$reportsUpdate);
		}

		$data =[$info['name'] => $info['issetval']];
		$this->Ambassadormodel->updateData('ambassador_reports',$data,'user_id',$info['ambassador_id']);
		echo 1;
	}

	public function ambassadorsDropdown()
	{
		$dropInfo = $this->input->post();

		$ambassadorsId = $dropInfo['ambassador_id'];
		$clientId = $dropInfo['client_id']; 
		$action = $dropInfo['action'];

		if($action == 'add'){
			$dataInsert = [
				'ambassador_id' => $ambassadorsId,
				'user_id' => $clientId,
			];
			$this->Ambassadormodel->insertData('ambassador_match', $dataInsert);

		}else{
			$this->Ambassadormodel->deleteAmData($dropInfo);
		}
		echo 1; 

	}

	public function deactiveUser($id){
		$data =['active' => 0];
		$this->Ambassadormodel->updateData('users',$data,'id',$id);
		
		$success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);	
	}
	public function activeUser($id){
		$data =['active' => 1];
		$this->Ambassadormodel->updateData('users',$data,'id',$id);
		redirect(base_url() . 'ambassadors', 'refresh');	
	}

	public function ambassadorsAdd()
	{
		$info = $this->input->post();

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect(base_url() . 'ambassadors', 'refresh');
		} else {

			$name = $info['name'];
			$email = $info['email'];
			$password = md5($info['password']);

			$data = [
				'full_name' => $name,
				'email' => $email,
				'password' => $password,
				'account_level' => 'ambassador',
				'active' => 1,
			];
			$userId = $this->Ambassadormodel->insertData('users', $data);
			redirect(base_url() . 'ambassadors', 'refresh');
		}
	}

	public function ambassadorsEdit($id){
		// echo "<pre>"; print_r($ambassadors['ambassedit']); die();
		
		$data = [];
		$ambassadors = $this->Ambassadormodel->getAmbassadors();
		foreach($ambassadors as $amb){		
			$amb->clients =  $this->Ambassadormodel->getAllAmbsclient($amb->id);
			$amb->reports =  $this->Ambassadormodel->getAllReports($amb->id);
			$ambassadors['ambassadors'][]= $amb;
		}
		$ambassadors['clients']=$this->Ambassadormodel->getAllClients();
		$ambassadors['ambassedit']=$this->Ambassadormodel->getSpecificAmbassadors($id);

		$info = $this->input->post();
		if(count($info) > 0 ){

			$name = $info['name'];
			$email = $info['email'];
			$password = md5($info['password']);

			$update = [
				'full_name' => $name,
				'email' => $email,
				'password' => $password,
			];

			$this->Ambassadormodel->updateData('users',$update,'id',$id);
			redirect(base_url() . 'ambassadors', 'refresh');
			// echo $this->db->last_query(); die();
		}

		$data['full_content'] =  $this->load->view('ambassadors/edit-ambassador', $ambassadors, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function uploadKeywordCSv()
	{
	    
	    $id = $this->session->userdata('id');
		$allClintes = $this->Ambassadormodel->getAllAmbsclient($id);

		$myClient = $allClintes[0];
		if ($this->session->userdata('myClient')  != NULL) {
			$myClient =  $this->session->userdata('myClient');
		}
		
// 		print_r($myClient); die();
	    
	    
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
					
					if($i != 1){
						$key = [];
						$key['crawler_id'] = $myClient;
						$key['keyword'] = $row['0'];
						$key['must_include_keywords'] = $row['1'];
						$key['must_include_condition'] = $row['2'];
						$key['must_exclude_keywords'] = $row['3'];
						$key['recommended_reply'] = $row['4'];

						$this->Crawler->insertData('keywords', $key);
					}
					$i++;

				}
				// echo "<pre>";
				// print_r($key);
				// die();

				$this->session->set_flashdata('success', 'CSV uploaded successfully!');
				redirect(base_url() . 'ambass_key_view', 'refresh');
			} else {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('csv_error', $error);
				redirect(base_url() . 'ambass_key_view', 'refresh');
			}
		}
		//	while ($row = fgetcsv($handle))
	}

	public function ambassadorsAccount($id)
	{
		$data = [];
		$user_data = [];

		// $ambassId = $this->session->userdata('id');
		// echo $ambassId; die();

		$allClintes = $this->Ambassadormodel->getAllAmbsclient($id);
		$myClient = $allClintes[0];
		if ($this->session->userdata('myClient')  != NULL) {
			$myClient =  $this->session->userdata('myClient');
		}

		$user_data['usersinfo'] = $this->Ambassadormodel->getAllCrawlerUnderAmbassadors($id);
		// echo "<pre>"; print_r($user_data['usersinfo']); die();

		$user_data['info'] = $this->Crawler->getUserInfo($myClient);
		$user_data['keywords'] = $this->Crawler->getMyKeyowrd($myClient);
		$user_data['groups'] = $this->Crawler->getAllGroups($myClient);
		$user_data['tags'] = $this->Crawler->getAllTags($myClient);
		$user_data['id'] = $myClient;

		$user_data['suggested_keys'] = $this->Clientonboardingmodel->getAllSuggestedKeyword();
		// echo "<pre>"; print_r($user_data); die();
		
		$user_data['timezones'] = $this->Crawler->getAllTimzones();

		$user_data['selected_groups'] = $this->Ambassadormodel->getSelectedGroupCategories($myClient);
		// $user_data['selected_keyword'] = $this->Ambassadormodel->getSelectedKeyword($myClient);


		$info = $this->input->post();
		if(count($info) > 0){
			// echo "hi"; die();
			// echo $info['category_filter']; die();
			$user_data['usersinfo'] = $this->Ambassadormodel->getAllCrawlerUnderAmbassadors($id, $info['category_filter']);
		}

		// echo '<pre>';
		// print_r($user_data['selected_groups']);
		// die();

		$data['full_content'] =  $this->load->view('ambassadors/accounts', $user_data, TRUE);
		$this->load->view('layout/master', $data);
	}



	public function updateProfileInfo(){
		$info = $this->input->post();

		$profileId = $info['profile_id'];
		$profileName = $info['profile_name'];
		$profileEmail = $info['profile_email'];

		if($info['old_password'] != '' && $info['new_password'] != ''){
			$oldpass =  md5($info['old_password']);
			$newpass =  md5($info['new_password']);

			$myinfo = $this->Crawler->getMyInfo($profileId, $oldpass);

			if ($myinfo == true) {
				$pass = ['password' => $newpass];
				$this->Crawler->updateData('users', $pass, 'id', $profileId);

				$result ['success'] = 'Password has been Update successfully.';
				echo json_encode($result);
			} else {
				$result['error'] = 'Password Not Matched.';
				echo json_encode($result);
			}
		}else{
			$updateProfileInfo = [
				'email' =>  $profileEmail,
				'full_name' =>  $profileName,
			];

			$result['info'] = $this->Ambassadormodel->updateData('users',$updateProfileInfo,'id',$profileId);
			echo json_encode($result);
		}

	}

	/*======================================
        All Data Ambassador Profile
    ======================================*/
	public function ambassadorProfile(){
		// echo "hi"; die();
		// echo "<pre>"; print_r($_POST); die();
		
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
					"fb_group_id" => $group_url,
					"fb_group_name" => str_replace("#", "", $group->fb_group_name),
					"group_category" => $group->group_category,
					"fb_group_uri" => "https://www.facebook.com/groups/" . $group_url,
					"type" => $group->type,
					"connected" => 1
				];
				// echo "<pre>"; print_r($groups);
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
					'keyword' => $key_value,
					'must_include_keywords' => $must_include_keywords,
					'must_include_condition' => $must_include_condition,
					'must_exclude_keywords' => $must_exclude_keywords,
					'recommended_reply' => $recommended_reply,
				];

				// echo "<pre>"; print_r($insertKeyword);
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

			$insertKeyword = [
				'crawler_id' => $mcrawlers,
				// 'notification_type' => $notification_type,
				'notification_address' => $notification_address,
				'notification_interval' => $notification_interval,
				'notification_timezone' => $notification_timezone,
				'notification_starts' => $notification_starts,
				'notification_ends' => $notification_ends,
			];
			// echo "<pre>"; print_r($groups); die();
			$this->Clients->insertData('notification_settings', $insertKeyword);
		}

		$this->session->set_flashdata('success', 'Client onboarding from has been added successfully.');
		// die();
		$id = $this->session->userdata('id');
		redirect(base_url() . 'ambassadors_account/'.$id, 'refresh');
	}


}
