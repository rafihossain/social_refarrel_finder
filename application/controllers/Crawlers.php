<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crawlers extends CI_Controller
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

		$this->load->helper('checkrequest');
		$this->load->library("pagination");

		if (!$this->session->userdata('login_state')) {
			return redirect(base_url());
		}
	}

	public function index()
	{
		$this->session->unset_userdata('keyword');
		$data = [];
		$config = array();
		$config["base_url"] = base_url() . "crawlers";
		$config["total_rows"] = $this->Crawler->countSearchKeywordValue();
		$config["per_page"] = 10;
		$config["uri_segment"] = 2;

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$crawlers["links"] = $this->pagination->create_links();
		$crawlers['crawlers'] = $this->Crawler->getSearchKeywordValue($config["per_page"], $page);

		$data['full_content'] =  $this->load->view('crawlers/index', $crawlers, TRUE);
		$this->load->view('layout/master', $data);
	}

/*=======================================================================
        Crawler Recommendation Start
=========================================================================*/

    public function crawlerRecommendation()
    {
        $data = [];
        $id = $this->session->userdata('id');

        $allReport['tags'] = $this->Clients->getAllTag($id);
        $allReport['filtered_tags'] = '';
        $allReport['top_level_tag'] = 0;
        $allReport['recommendations'] = [];
        $data['full_content'] =  $this->load->view('recommendation/crawler_recommedation', $allReport, TRUE);
        $this->load->view('layout/master', $data);
    }

    public function getCrawlerFilterData()
    {
        // echo $this->uri->segment(2); die();
        
        $id = $this->session->userdata('id');
		$getClient = $this->Clients->getCrawlerToClientUserId($id);
	    
	    $info = $this->input->post();
		// echo "<pre>"; print_r($info); die();

		if (count($info) > 0) {
			$this->session->set_userdata('searchInfo', $info);
		} else {
			$info = $this->session->userdata('searchInfo');
		}
		// echo 11; die();
		if ($info['filter_tags'][0] == 0 || $info['filter_tags'][0] == 1 || $info['filter_tags'][0] == 2 || $info['filter_tags'][0] == 3) {
			// echo 22; die();
			// echo 'hi'; die();

			$config = array();
			$config["base_url"] = base_url() . "getcrawlerrecommendation";
			$config["total_rows"] = $this->Crawler->count_all($getClient);
			
			// echo $this->db->last_query();
			// echo "<pre>"; print_r($config["total_rows"]); die();

			$config["per_page"] = 10;
			$config["uri_segment"] = 2;
			$config['attributes'] = array('class' => 'myclass');
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$filterData["links"] = $this->pagination->create_links();
            $list = $this->Crawler->getCrawlersDatatables($config["per_page"], $page, $getClient);
			// echo $this->db->last_query();
			// echo "<pre>"; print_r($list); die();

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

			// echo "<pre>"; print_r($data); di e();

			$filterData["reports"] = $data;
			
			//  echo "<pre>"; print_r($filterData); die();

			$htmldata[] = $this->load->view('recommendation/reponse/crawler-response', $filterData, true);
		//	echo 2342;die();
			echo json_encode($htmldata);

        }else{
			// echo 33; die();
            $config = array();
			$config["base_url"] = base_url() . "getcrawlerrecommendation";
			$config["total_rows"] = $this->Crawler->count_allForCustom($getClient);
			
			// echo $this->db->last_query();
			// echo "<pre>"; print_r($config["total_rows"]); die();

			$config["per_page"] = 10;
			$config["uri_segment"] = 2;
			$config['attributes'] = array('class' => 'myclass');
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$filterData["links"] = $this->pagination->create_links();
            $list = $this->Crawler->get_datatablesCustom($config["per_page"], $page, $getClient);
			// echo "<pre>"; print_r($list); die();
			
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
                $row['keyword_id'] = $this->Crawler->getkeyWord($recommendation->keyword_id);
			// echo $this->db->last_query();
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

    
    public function updateCrawlerTag(){
        
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
                Crawler Recommendation End
    =========================================================================*/


	public function findingValue()
	{
		$data = [];

		$searchInput = '';
		if ($this->session->userdata('keyword')) {
			$searchInput = $this->session->userdata('keyword');
		}

		if ($this->input->post('search_input') != '') {
			$searchInput = $this->input->post('search_input');
			$this->session->set_userdata('keyword', $searchInput);
		}


		$config = array();
		$config["base_url"] = base_url() . "finding_value";

		if ($searchInput != '') {
			$config["total_rows"] = $this->Crawler->countSearchKeywordValue($searchInput);
		}

		$config["per_page"] = 10;
		$config["uri_segment"] = 2;

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$crawlers["links"] = $this->pagination->create_links();

		if ($searchInput != '') {
			$crawlers['crawlers'] = $this->Crawler->getSearchKeywordValue($config["per_page"], $page, $searchInput);
		}

		/*========================================
					Sorting
		==========================================*/
		$sorting = $this->input->post('filter_input');
		if ($sorting != '') {
			$crawlers['crawlers'] = $this->Crawler->getAssendingAndDesendingCrawler($config["per_page"], $page, $searchInput, $sorting);
		}
		$crawlers['hasresult'] = 0;
		if (!empty($crawlers['crawlers']) && count($crawlers['crawlers']) > 0) {
			$crawlers['hasresult'] = 1;
		}

		$data['full_content'] =  $this->load->view('crawlers/index', $crawlers, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function addcrawler()
	{
		$data = [];
		// $crawlers['clients'] = $this->Crawler->getAllClient();
		$crawlers['plans'] = $this->Crawler->getAllPlan();
		$data['full_content'] =  $this->load->view('crawlers/firststep', $crawlers, TRUE);
		$this->load->view('layout/master', $data);
	}


	public function submitAddcrawler()
	{
		$info = $this->input->post();
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect(base_url() . 'addcrawler', 'refresh');
		} else {
			$nstring = rand();
			$this->session->set_userdata('first_form', $info);
			redirect(base_url() . 'add_facebook_groups', 'refresh');
		}
	}

	public function secondStep()
	{
		$data = [];
		// $data['groups_data'] = $this->session->userdata('groups_data');
		$data['full_content'] =  $this->load->view('crawlers/secondstep', '', TRUE);
		$this->load->view('layout/master', $data);
	}


	public function submitSecondStep()
	{
		$info = $this->input->post('group');
		$myInfo =  json_decode($info);
		$this->form_validation->set_rules('group', 'Group', 'trim|required');
		if ($this->form_validation->run() == false) {
// 			redirect(base_url() . 'sndstep', 'refresh');
		} else {
			$nstring = rand();
			$test = $this->session->set_userdata('second_form', $info);
			// print_r($test); die();

			redirect(base_url() . 'notification_setting', 'refresh');
		}
	}

	public function fbGroupCsv()
	{
		// echo "hi"; die();
		// $this->session->unset_userdata('groups_data');


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
						$groupsData[$i]['group_name'] = $row[0];
						$groupsData[$i]['group_url'] = $row[1];
						$groupsData[$i]['group_category'] = $row[2];
						$groupsData[$i]['type'] = $row[3];
						$groupsData[$i]['join_status'] = $row[4];
					}
					$i++;
				}
				$groupsData = array_values($groupsData);
		

				$this->session->set_userdata('groups_data', $groupsData);
				$this->session->set_flashdata('success', 'CSV uploaded successfully!');
			} else {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('csv_error', $error);
			}

			// $data['full_content'] =  $this->load->view('crawlers/secondstep', $groupsData, TRUE);
			// $this->load->view('layout/master', $data);

			redirect(base_url() . 'add_facebook_groups', 'refresh');
		}
	}
	public function thirdStep()
	{
		$data = [];
		$cl['timezones'] = $this->Crawler->getAllTimzones();
		$data['full_content'] =  $this->load->view('crawlers/thirdstep', $cl, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function submitThirdStep()
	{
		$this->session->unset_userdata('groups_data');

		$info = $this->input->post();
		$this->form_validation->set_rules('notification_type', 'Notification Type', 'trim|required');
		$this->form_validation->set_rules('notification_address', 'Notification Address', 'trim|required');
		$this->form_validation->set_rules('notification_timezone', 'notification   Timezone', 'trim|required');
		$this->form_validation->set_rules('notification_starts', 'Notification Starts', 'trim|required');
		$this->form_validation->set_rules('notification_ends', 'Notification Ends', 'trim|required');

		if ($this->form_validation->run() == false) {
			redirect(base_url() . 'trdstep', 'refresh');
		} else {
			$info = $this->input->post();
			$first_form = $this->session->userdata('first_form');
			$second_form = $this->session->userdata('second_form');

			$guid = bin2hex(openssl_random_pseudo_bytes(16));
			$newdata = [
				'full_name' => $first_form['name'],
				'email' => $first_form['email'],
				'password' => md5($first_form['password']),
				'unique_identifier' => $guid,
				'account_level' => 'crawler',
				// 'current_plan' => $first_form['current_plan'],
				'active' => (isset($first_form['active']) && $first_form['active'] == 1 ? 1 : 0)
			];

			// var_dump($first_form['clients']);die();
			// echo "<pre>"; print_r($newdata); die();


			$id = $this->Crawler->insertData('users', $newdata);

			if ($id) {
				if (isset($first_form['clients']) && $first_form['clients'] != '') {
					$this->Crawler->whereInClient($first_form['clients'], $id);
				}
				$groups = json_decode($second_form);
				// echo "<pre>"; print_r($groups); die();

				foreach ($groups as $gr) {
					$group_url = str_replace("https://", "", $gr->group_url);
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
						"crawler_id" => $id,
						"fb_group_id" => $group_url,
						"fb_group_name" => str_replace("#", "", $gr->group_name),
						"group_category" => $gr->group_category,
						"fb_group_uri" => "https://www.facebook.com/groups/" . $group_url,
						"type" => $gr->type,
						"connected" => 1
					];
					// echo "<pre>"; print_r($groups); die();
					$gid = $this->Crawler->insertData('groups', $groups);
				}

				$info['crawler_id'] = $id;
				$this->Crawler->insertData('notification_settings', $info);
			}
			// die();
			redirect(base_url() . 'crawlers', 'refresh');
		}
		// $group_url = $_POST["group_url"];
	}

	public function editcrawler($id)
	{
		$data = [];
		$user_data = [];
		$user_data['info'] = $this->Crawler->getUserInfo($id);

		$user_data['groups'] = $this->Crawler->getAllGroups($id);
		// $user_data['tags'] = $this->Crawler->getAllTags($id);
		$user_data['id'] = $id;
		$data['full_content'] =  $this->load->view('crawlers/editcrawlers', $user_data, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function deleteCrawler($id)
	{
		// $update = [
		// 	'active' => 0
		// ];
		$this->Crawler->deleteData('users', 'id', $id);

		$success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);
	}

	public function addCrawlerTag($id)
	{
		$info = $this->input->post();
		$this->form_validation->set_rules('tag', 'Tag', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', 'Tag Is Empty');
			redirect(base_url() . 'editcrawler/' . $id, 'refresh');
		} else {
			$info = $this->input->post();
			$info['crawler_id'] = $id;
			$this->Crawler->insertData('tags', $info);
			$this->session->set_flashdata('sucess', 'Tag ' . $info['tag'] . ' has been added successfully.');
			redirect(base_url() . 'editcrawler/' . $id, 'refresh');
		}
	}


	public function deleteCrawlerTag($id, $cid)
	{
		$this->Crawler->deleteData('tags', 'id', $id);
		// 		$this->session->set_flashdata('sucess','Tag has been delete successfully.');
		// 		redirect(base_url() . 'editcrawler/'.$cid, 'refresh');

		$success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);
	}


	public function addCrawlerGroup($id)
	{
		$info = $this->input->post();
		$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
		$this->form_validation->set_rules('group_url', 'Group Url', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('group_error', 'Group name or Group url Is Empty');
			redirect(base_url() . 'editcrawler/' . $id, 'refresh');
		} else {
			$info = $this->input->post();
			$info['crawler_id'] = $id;

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

			$groups = [
				"crawler_id" => $id,
				"fb_group_id" => $group_url,
				"fb_group_name" => str_replace("#", "", $info['group_name']),
				"group_category" => $info['group_category'],
				"fb_group_uri" => "https://www.facebook.com/groups/" . $group_url,
				"type" => $info['type'],
				"connected" => 1
			];
			$gid = $this->Crawler->insertData('groups', $groups);
			$this->session->set_flashdata('group_sucess', 'Group has been added successfully.');
			redirect(base_url() . 'editcrawler/' . $id, 'refresh');
		}
	}

	public function crawlerEditGroup($id, $cid)
	{
		// $groupdata = [];
		$group = $this->Crawler->getGroupData($id, $cid);

		$info = $this->input->post();
		if (count($info) > 0) {
			$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
			$this->form_validation->set_rules('group_url', 'Group Url', 'trim|required');
			if ($this->form_validation->run() == false) {
			} else {
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

				$groupUpdate = [
					"crawler_id" => $id,
					"fb_group_id" => $group_url,
					"fb_group_name" => str_replace("#", "", $info['group_name']),
					"group_category" => $info['group_category'],
					"fb_group_uri" => "https://www.facebook.com/groups/" . $group_url,
					"type" => $info['type'],
					"connected" => 1
				];
				// echo "<pre>";
				// print_r($groupUpdate);
				// die();

				$this->Crawler->updateGroup('groups', $groupUpdate, $id, $cid);

				$this->session->set_flashdata('group_sucess', 'Group has been updated successfully.');
				redirect(base_url() . 'editcrawler/' . $id, 'refresh');
			}
		}

		$groupdata = [
			'id' => $id,
			'gid' => $cid,
			'getgroupdata' => $group
		];

		$data['full_content'] =  $this->load->view('crawlers/edit-crawlers-group', $groupdata, TRUE);
		$this->load->view('layout/master', $data);


		// $groups = ["connected" => 0];
		// $gid = $this->Crawler->updateData('groups', $groups, 'id', $id);
		// // 		$this->session->set_flashdata('group_sucess','Group has been Disconnect successfully.');
		// // 		redirect(base_url() . 'editcrawler/'.$cid, 'refresh');

		// $success = [
		// 	'success' => 'Group has been Disconnect successfully',
		// ];
		// echo json_encode($success);
	}

	public function crawlerDisconnectGroup($id, $cid)
	{

		$groups = ["connected" => 0];
		$gid = $this->Crawler->updateData('groups', $groups, 'id', $id);
		// 		$this->session->set_flashdata('group_sucess','Group has been Disconnect successfully.');
		// 		redirect(base_url() . 'editcrawler/'.$cid, 'refresh');

		$success = [
			'success' => 'Group has been Disconnect successfully',
		];
		echo json_encode($success);
	}

	public function addKeyword($id)
	{
		$info = $this->input->post();
		$this->form_validation->set_rules('keyword', 'Keyword', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('keyword_error', 'keywords is Empty');
			redirect(base_url() . 'editcrawler/' . $id, 'refresh');
		} else {
			$info = $this->input->post();
			$info['crawler_id'] = $id;
			$info['client_id'] = 0;
			$gid = $this->Crawler->insertData('keywords', $info);
			$this->session->set_flashdata('keyword_sucess', 'keywords has been added successfully.');
			redirect(base_url() . 'editcrawler/' . $id, 'refresh');
		}
	}


	public function crawlerDeleteKeyword($id, $cid)
	{
		$this->Crawler->deleteData('keywords', 'id', $id);
		// 		$this->session->set_flashdata('keyword_sucess','keywords has been delete successfully.');
		// 		redirect(base_url() . 'editcrawler/'.$cid, 'refresh');

		$success = [
			'success' => 'Keywords has been delete successfully',
		];
		echo json_encode($success);
	}

	public function editcrawlerInfo($id)
	{
		$data = [];
		$user_data = [];
		$user_data['info'] = $this->Crawler->getUserInfo($id);
		$user_data['id'] = $id;
		$data['full_content'] =  $this->load->view('crawlers/updatecrawlerinfo', $user_data, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function updateCrawlerInfo($id)
	{
		$info = $this->input->post();
		if ($info['password'] == '') {
			unset($info['password']);
		} else {
			$info['password'] = md5($info['password']);
		}

		if (!isset($info['active'])) {
			$info['active'] = 0;
		}
		$gid = $this->Crawler->updateData('users', $info, 'id', $id);
		$this->session->set_flashdata('sucess', 'Crawler has been update successfully.');
		redirect(base_url() . 'editcrawlerinfo/' . $id, 'refresh');
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
		$user_data['info'] = $this->Crawler->getUserInfo($myClient);
		$user_data['keywords'] = $this->Crawler->getMyKeyowrd($myClient);
		$user_data['groups'] = $this->Crawler->getAllGroups($myClient);
		$user_data['tags'] = $this->Crawler->getAllTags($myClient);
		$user_data['id'] = $myClient;
		$user_data['suggested_keys'] = $this->Clientonboardingmodel->getAllSuggestedKeyword();
		$user_data['timezones'] = $this->Crawler->getAllTimzones();

		// echo '<pre>';
		// print_r($user_data);
		// die();

		$data['full_content'] =  $this->load->view('ambassadors/accounts', $user_data, TRUE);
		$this->load->view('layout/master', $data);
	}

	// public function getClientUndermbasder(){

	// }

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
			redirect(base_url() . 'ambassadors_account/' . $id, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Password Not Matched.');
			redirect(base_url() . 'ambassadors_account/' . $id, 'refresh');
		}
	}


	public function ambassadorsNotification($id)
	{
		// echo "hi";
		// die();
		$data = [];

		$allClintes = $this->Ambassadormodel->getAllAmbsclient($id);

		$myClient = $allClintes[0];
		if ($this->session->userdata('myClient')  != NULL) {
			$myClient =  $this->session->userdata('myClient');
		}

		$user_data = [];
		$user_data['info'] = $this->Crawler->getUserInfo($myClient);

		// echo '<pre>';
		// print_r($user_data['info']);
		// die();


		$user_data['timezones'] = $this->Crawler->getAllTimzones();
		$user_data['notifications'] = $this->Crawler->notificationSettings($myClient);


		$user_data['id'] = $myClient;
		$data['full_content'] =  $this->load->view('crawlers/notification_settings', $user_data, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function changeStatus($id)
	{
		$info = $this->input->post();
		$cahneval = ['daily_report' => $info['changeval']];
		$this->Crawler->updateData('users', $cahneval, 'id', $id);
		echo 1;
	}

	public function uploadCSv($id)
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
				while ($row = fgetcsv($handle)) {
					if ($i != 1) {
						$group_url = str_replace("https://", "", $row[1]);
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
							"crawler_id" => $id,
							"fb_group_id" => $group_url,
							"fb_group_name" => str_replace("#", "", $row[0]),
							"fb_group_uri" => "https://www.facebook.com/groups/" . $group_url,
							"type" => $row[2],
							"connected" => 1
						];

						$this->Crawler->insertData('groups', $groups);
					}
					$i++;
				}
				$this->session->set_flashdata('success', 'CSV uploaded successfully!');
				redirect(base_url() . 'editcrawler/' . $id, 'refresh');
			} else {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('csv_error', $error);
				redirect(base_url() . 'editcrawler/' . $id, 'refresh');
			}
		}
	}

	public function viewKeyword($id)
	{
		$data = [];
		$keys['keywords'] = $this->Crawler->viewKeyword($id);


		$keys['cid'] =  $id;
		$keys['cinfo'] = $this->Crawler->getClientsinfo($id);
		// echo "<pre>";
		// print_r($keys);
		// die();
		$data['full_content'] =  $this->load->view('admin-keyword/index', $keys, TRUE);
		$this->load->view('layout/master', $data);
	}
	public function addClientKeyword($id)
	{
		$info = $this->input->post();

		$multirecomreply = implode(',', $info['recommended_reply']);

		$getMulticrawlers = $this->Crawler->getMultiCrawlersInfo($id);

		$key = [];
		$key['keyword'] = $info['keyword'];
		$key['recommended_reply'] = $multirecomreply;
		$key['must_include_keywords'] = $info['must_include_keywords'];
		$key['must_include_condition'] = $info['must_include_condition'];
		$key['must_exclude_keywords'] = $info['must_exclude_keywords'];

		for ($j = 0; $j < count($getMulticrawlers); $j++) {
			$key['crawler_id']  =  $getMulticrawlers[$j];
			$key['end_client_id'] = $id;
			$this->Crawler->insertData('keywords', $key);
		}

		$this->session->set_flashdata('keyword_sucess', 'keywords has been added successfully.');
		redirect(base_url() . 'viewkeyword/' . $id, 'refresh');
	}

	public function crawlerEditKeyword($id, $cid)
	{
		$key_data = [];
		$key_data['keyword'] = $this->Crawler->getSingleKeyword($id);
		$key_data['cid'] = $cid;
		$key_data['cinfo'] = $this->Crawler->getClientsinfo($cid);


		// $data['full_content'] =  $this->load->view('crawlers/edit-crawlers-keyword', $key_data, TRUE);
		$data['full_content'] =  $this->load->view('admin-keyword/edit', $key_data, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function updateCrwalerkeyword($id, $cid)
	{
		$info = $this->input->post();

		$multirecomreply = implode(',', $info['recommended_reply']);
		$info['recommended_reply'] = $multirecomreply;

		$this->Crawler->updateData('keywords', $info, 'id', $id);
		// echo $this->db->last_query();

		// echo "<pre>";
		// print_r($info);
		// die();

		$this->session->set_flashdata('sucess', 'Keyword has been update successfully.');
		redirect(base_url() . 'viewkeyword/' . $cid, 'refresh');
		// redirect(base_url() . 'editKeyword/' . $id . '/' . $cid, 'refresh');
	}
	public function updateMustincValue()
	{
		$info = $this->input->post();
		$id = $info['id'];

		$update = [
			'must_include_keywords' => $info['updateVal']
		];

		$results = $this->Crawler->updateData('keywords', $update, 'id', $id);
		echo json_encode($results);
	}
	public function removeMustincValue()
	{
		$info = $this->input->post();
		$id = $info['id'];

		$update = [
			'must_include_keywords' => $info['removeVal']
		];

		$results = $this->Crawler->updateData('keywords', $update, 'id', $id);
		echo json_encode($results);
	}

	public function updateRecomreplyValue()
	{
		$info = $this->input->post();
		$id = $info['id'];

		$update = [
			'recommended_reply' => $info['updateVal']
		];

		$results = $this->Crawler->updateData('keywords', $update, 'id', $id);
		echo json_encode($results);
	}
	public function removeRecomreplyValue()
	{
		$info = $this->input->post();
		$id = $info['id'];

		$update = [
			'recommended_reply' => $info['removeRecomVal']
		];

		$results = $this->Crawler->updateData('keywords', $update, 'id', $id);
		echo json_encode($results);
	}



	public function uploadKeywordCSv($id)
	{
		$getMulticrawlers = $this->Crawler->getMultiCrawlersInfo($id);

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
							$key['crawler_id']  =  $getMulticrawlers[$j];
							$key['end_client_id'] = $id;
							$this->Crawler->insertData('keywords', $key);
						}
					}
					$i++;
				}
				// echo "<pre>";
				// print_r($test);
				// die();

				$this->session->set_flashdata('success', 'CSV uploaded successfully!');
				redirect(base_url() . 'viewkeyword/' . $id, 'refresh');
			} else {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('csv_error', $error);
				redirect(base_url() . 'viewkeyword/' . $id, 'refresh');
			}
		}
		//	while ($row = fgetcsv($handle))
	}


	public function adminDeleteKeyword($id, $cid)
	{
		$this->Crawler->deleteData('keywords', 'id', $id);
		$this->session->set_flashdata('keyword_sucess', 'keywords has been delete successfully.');
		//$this->session->set_flashdata('keyword_sucess','keywords has been added successfully.');
		//redirect(base_url() . 'viewkeyword/' . $cid, 'refresh');

		$success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);
	}

	public function ambassadorViewClientGroups()
	{   
	    $id = $this->session->userdata('id');
	    $allClintes = $this->Ambassadormodel->getAllAmbsclient($id);

		$myClient = $allClintes[0];
		if ($this->session->userdata('myClient')  != NULL) {
			$myClient =  $this->session->userdata('myClient');
		}
		
		$group['groups'] = $this->Clients->getAllClientFacebookGroup($myClient);


		$data['full_content'] =  $this->load->view('ambassadors/groups/index', $group, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function ambassadorViewClientKeyword()
	{
	    $id = $this->session->userdata('id');
		$allClintes = $this->Ambassadormodel->getAllAmbsclient($id);

		$myClient = $allClintes[0];
		if ($this->session->userdata('myClient')  != NULL) {
			$myClient =  $this->session->userdata('myClient');
		}

		$data = [];
		$keys['keywords'] = $this->Crawler->getAllCrawlerKeywords($myClient);
		$keys['cinfo'] = $this->Crawler->getClientsinfo($myClient);

		$data['full_content'] =  $this->load->view('ambassadors/keyword/index', $keys, TRUE);
		$this->load->view('layout/master', $data);
	}


	public function ambassadorsAddGroup()
	{
		$info = $this->input->post();

		$id = 0;
		if ($this->session->userdata('myClient')  != NULL) {
			$id =  $this->session->userdata('myClient');
		}
		
	   // echo "<pre>"; print_r($id); die();

		$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
		$this->form_validation->set_rules('group_url', 'Group Url', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('group_error', 'Group name or Group url Is Empty');
			// redirect(base_url() . 'editcrawler/' . $id, 'refresh');
		} else {
		    
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
			    "crawler_id" => $id,
				"fb_group_id" => $group_url,
				"fb_group_name" => str_replace("#", "", $info['group_name']),
				"group_category" => $info['group_category'],
				"fb_group_uri" => "https://www.facebook.com/groups/" . $group_url,
				"type" => $info['type'],
				"connected" => $info['join_status']
			];
			$this->Crawler->insertData('groups', $groups);
			

			$this->session->set_flashdata('group_sucess', 'Group connected successfully.');
			redirect(base_url() . 'ambass_groups_view', 'refresh');
		}
	}

	public function ambassDisconnectGroup($id)
	{
		// echo "hi"; die();
		$groups = ["connected" => 0];
		$this->Crawler->updateData('groups', $groups, 'id', $id);

		$this->session->set_flashdata('group_sucess', 'Group has been Disconnect successfully.');
		// redirect(base_url() . 'ambass_groups_view', 'refresh');

		$success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);
	}


	/*=================keyword================*/
	public function ambassadorAddKeyword()
	{
		$id = 0;
		if ($this->session->userdata('myClient')  != NULL) {
			$id =  $this->session->userdata('myClient');
		}

		$this->form_validation->set_rules('keyword', 'Keyword', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('group_error', 'Group name or Group url Is Empty');
			// redirect(base_url() . 'clientkeyword', 'refresh');
		} else {
			$info = $this->input->post();

			$multirecomreply = implode(',', $info['recommended_reply']);
// 			$getMulticrawlers = $this->Clients->multiCrawlersInfoForClient($id);

			$key = [];
			$key['crawler_id']  =  $id;
			$key['keyword'] = $info['keyword'];
			$key['recommended_reply'] = $multirecomreply;
			$key['must_include_keywords'] = $info['must_include_keywords'];
			$key['must_include_condition'] = $info['must_include_condition'];
			$key['must_exclude_keywords'] = $info['must_exclude_keywords'];
			$key['active'] = 1;

			$this->Crawler->insertData('keywords', $key);

			$this->session->set_flashdata('sucess', 'keywords has been added successfully.');
			redirect(base_url() . 'ambass_key_view', 'refresh');
		}
	}

	public function ambassadorEditKeyword($id)
	{
		$data = [];
		$uid = $this->session->userdata('id');
		$keys['keyword'] = $this->Clients->getSingleKeyword($id);
		$data['full_content'] =  $this->load->view('ambassadors/keyword/edit', $keys, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function ambassadorUpdateKeyword($id)
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
		redirect(base_url() . 'ambass_key_view', 'refresh');
	}

	public function ambassDeleteKey($id)
	{
		$this->Clients->deleteData('keywords', 'id', $id);
		$this->session->set_flashdata('sucess', 'Keywords has been Delete successfully.');
		// redirect(base_url() . 'clientkeyword', 'refresh');

		$success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);
	}

	public function crawlerGroups()
	{
		$id = $this->session->userdata('id');
		$group['groups'] = $this->Clients->getAllClientFacebookGroup($id);

		$info = $this->input->post();
		if (count($info) > 0) {
			$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
			$this->form_validation->set_rules('group_url', 'Group Url', 'trim|required');
			if ($this->form_validation->run() == false) {
			} else {

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

				$groups = [
					"crawler_id" => $id,
					"fb_group_id" => $group_url,
					"fb_group_name" => str_replace("#", "", $info['group_name']),
					"group_category" => $info['group_category'],
					"fb_group_uri" => "https://www.facebook.com/groups/" . $group_url,
					"type" => $info['type'],
					"connected" => $info['join_status']
				];

				$this->Crawler->insertData('groups', $groups);

				$this->session->set_flashdata('group_success', 'Group connected successfully.');
				redirect(base_url() . 'crawler_groups', 'refresh');
			}
		}
		$data['full_content'] =  $this->load->view('crawlers/crawler-groups', $group, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function crawlerGroupsDelete($id)
	{
		// echo "hi"; die();
		$groups = ["connected" => 0];
		$this->Crawler->updateData('groups', $groups, 'id', $id);

		$success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);
	}
	public function crawlerKeyword()
	{
		$id = $this->session->userdata('id');
		$data = [];
		$keys['keywords'] = $this->Crawler->getAllCrawlerKeywords($id);
		$keys['cinfo'] = $this->Crawler->getCrawlersinfo($id);
		// echo "<pre>"; print_r($keys); die();

		$info = $this->input->post();
		if (count($info) > 0) {
			$this->form_validation->set_rules('keyword', 'Keyword', 'trim|required');
			if ($this->form_validation->run() == false) {
			} else {

				$multirecomreply = implode(',',$info['recommended_reply']);

				$info['crawler_id'] = $id;
				$info['recommended_reply'] = $multirecomreply;
				$info['active'] = 1;
				$this->Clients->insertData('keywords', $info);

				// echo "<pre>"; print_r($info); die();

				$this->session->set_flashdata('sucess', 'keywords has been added successfully.');
				redirect(base_url() . 'crawler_keyword', 'refresh');
			}
		}

		$data['full_content'] =  $this->load->view('crawlers/keyword/index', $keys, TRUE);
		$this->load->view('layout/master', $data);
	}


	public function crawlerUpdateKeyword($id)
	{
		$data = [];
		$keys['keyword'] = $this->Clients->getSingleKeyword($id);

		$info = $this->input->post();
		if (count($info) > 0) {
			$this->form_validation->set_rules('keyword', 'Keyword', 'trim|required');
			if ($this->form_validation->run() == false) {
			} else {
				// echo "<pre>"; print_r($info); die();

				$info = $this->input->post();
				$multirecomreply = implode(',',$info['recommended_reply']);	

				$info['recommended_reply'] = $multirecomreply;
				$info['active'] = 1;

				// echo "<pre>"; print_r($info); die();
				
				$this->Crawler->updateData('keywords', $info, 'id', $id);
				
				$this->session->set_flashdata('success', 'keywords has been update successfully.');
				redirect(base_url() . 'crawler_keyword', 'refresh');
			}
		}
		$data['full_content'] =  $this->load->view('crawlers/keyword/edit', $keys, TRUE);
		$this->load->view('layout/master', $data);
	}
	
	public function crawlerAccount()
	{
		// echo "hi"; die();
		$id = $this->session->userdata('id');
		
		$getClient = $this->Clients->getCrawlerToClientUserId($id);
		$getMulticrawlers = $this->Crawler->getCrawlersUnderClient($getClient);
        $crawler = array_column($getMulticrawlers, 'crawler_id');
		
		$user_data['usersinfo'] = $this->Crawler->getCrawlerUserInfo($crawler);
		
		$user_data['info'] = $this->Crawler->getUserInfo($id);
		// echo "<pre>"; print_r($user_data['info']); die();


		$user_data['keywords'] = $this->Crawler->getMyKeyowrd($id);
		$user_data['groups'] = $this->Crawler->getAllGroups($id);
		$user_data['tags'] = $this->Crawler->getAllTags($id);

		$user_data['suggested_keys'] = $this->Clientonboardingmodel->getAllSuggestedKeyword();
		$user_data['timezones'] = $this->Crawler->getAllTimzones();

		$info = $this->input->post();
		if(count($info) > 0){
			// echo "hi"; die();
			$user_data['usersinfo'] = $this->Crawler->getCrawlerUserInfo($crawler, $info['category_filter']);
		}

		$data['full_content'] =  $this->load->view('crawlers/account', $user_data, TRUE);
		$this->load->view('layout/master', $data);
	}

	// public function showCrawlerName(){
	// 	$id = $this->session->userdata('id');
	// 	$getClient = $this->Clients->getCrawlerToClientUserId($id);
	// 	$getMulticrawlers = $this->Crawler->getCrawlersUnderClient($getClient);
    //     $crawler = array_column($getMulticrawlers, 'crawler_id');
		
	// 	$results = $this->Crawler->getCrawlerUserInfo($crawler);
	// 	echo json_encode($results);
	// 	// echo "<pre>"; print_r($user_data['info']); die();
	// }

	public function selectAllFacebookGroups()
	{
		$info = $this->input->post();

		$crawlerIds = $info['crawler_id'];
		for($i = 0; $i < count($crawlerIds); $i++){
			$value['crawler_picked'] = $crawlerIds[$i];
		}
		
		$groupIds = $info['group_id'];
		for($j = 0; $j < count($groupIds); $j++){
			$value['fb_groups'] = $groupIds[$j];
			$this->Clientonboardingmodel->insertData('clientonboarding_fbgroups',$value);
			// echo "<pre>";
			// print_r($value);
			$fbGroupsIdUpdate['status'] = 1;
			$this->Crawler->updateData('groups', $fbGroupsIdUpdate, 'id', $value['fb_groups']);
			// $this->Crawler->updateGroupsIdStatus('groups', $fbGroupsIdUpdate, 'id', $info['group_id']);
		}

		
		$cgroupInfo = $this->Crawler->getCrawlerGroupInformation($value['crawler_picked'], $value['fb_groups']);
		
		// echo "<pre>"; print_r($cgroupInfo); die();
		
		$results = [
			'cgroupinfo' => $cgroupInfo,
			'action' => $info['action'],
		];
		echo json_encode($results);
			// die();
		
		// echo "<pre>"; print_r($info); die();

	}	

	public function unselectAllFacebookGroups()
	{
		$info = $this->input->post();
		
		$groupIds = $info['group_id'];
		for($j = 0; $j < count($groupIds); $j++){
			$value['fb_groups'] = $groupIds[$j];
			$this->Crawler->deleteData('clientonboarding_fbgroups', 'fb_groups', $groupIds[$j]);
			
			$fbGroupsIdUpdate['status'] = 0;
			$result = $this->Crawler->updateData('groups', $fbGroupsIdUpdate, 'id', $groupIds[$j]);
		}
		// die();
		
		$results = [
			'cgroupinfo' => $result,
			'action' => $info['action'],
		];
		echo json_encode($results);
	}

	public function searchFacebookGroups()
	{
		$info = $this->input->post();

		if($info['filter_value'] != ''){
			$results = $this->Crawler->getFacebookGroupsSearchResults($info['crawler_id'],$info['search_input'],$info['filter_value']);
		}else{
			$results = $this->Crawler->getFacebookGroupsSearchResults($info['crawler_id'],$info['search_input']);
		}
		echo json_encode($results);
		// echo "<pre>"; print_r($result); die();
	}


	public function crawlerCsvKeyword($id)
	{
		// echo "<pre>"; print_r($getMulticrawlers); die();

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
						$key['crawler_id'] = $id;
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
			}

			$this->session->set_flashdata('success', 'CSV uploaded successfully!');
			redirect(base_url() . 'crawler_keyword', 'refresh');
		} else {
			$error = $this->upload->display_errors();
			$this->session->set_flashdata('csv_error', $error);
			redirect(base_url() . 'crawler_keyword', 'refresh');
		}
	}


	public function crawlerCsvGroup($id)
	{
		// echo "hi"; die();
		// $this->session->unset_userdata('groups_data');


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

						$group_url = str_replace("https://", "", $row[1]);
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
							"crawler_id" => $id,
							"fb_group_id" => $group_url,
							"fb_group_name" => str_replace("#", "", $row[0]),
							"group_category" => $row[2],
							"fb_group_uri" => "https://www.facebook.com/groups/" . $group_url,
							"type" => $row[3],
							"connected" => $row[4]
						];

						// echo "<pre>"; print_r($groups); die();

						$this->Crawler->insertData('groups', $groups);
					}
					$i++;
				}

				$this->session->set_flashdata('success', 'CSV uploaded successfully!');

			} else {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('csv_error', $error);
			}

			// $data['full_content'] =  $this->load->view('crawlers/secondstep', $groupsData, TRUE);
			// $this->load->view('layout/master', $data);

			redirect(base_url() . 'crawler_groups', 'refresh');
		}
	}

	/*======================================
        All Data Crawler Profile
    ======================================*/
	public function crawlerProfile(){
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
		redirect(base_url() . 'crawler_account', 'refresh');
	}


}
