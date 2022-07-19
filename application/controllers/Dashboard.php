<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
		$this->load->model('User');
		$this->load->model('Crawler');
		$this->load->model('Trigger');
		$this->load->model('Clients');
		$this->load->model('Ambassadormodel');
		// $this->load->model('FriendList_Model');

		if (!$this->session->userdata('login_state')) {
			return redirect(base_url());
		}
	}


	public function index()
	{
		$abc = $this->session->userdata();
		// echo "<pre>"; print_r($abc); die();

		$dashbord = [];
		// $date =  date('Y-m-d');
		// $new_date = date('Y-m-d', strtotime($date . ' - 7 days'));
		// $dashbord['datepicker_from'] = $new_date;
		// $dashbord['datepicker_to'] = date('Y-m-d');
		$data = [];

		///echo $this->session->userdata('account_level');die();
		if ($abc['account_level'] == 'admin') {
			$dashbord['clients'] = $this->Clients->getAllActiveClient();
			$dashbord['groups'] = $this->Clients->getAllConntectedGroupp();
			$dashbord['keyword'] = $this->Clients->getAllActiveKeyword();
			$dashbord['request_count'] = $this->Clients->getAllActiveRecommandedRequest();

			/*Dashboard chart data*/
			$year = date('Y');
			$month = date('m');

			// $startDate = $year . '-' . $month . '-' . '01';
			// $endDate = $year . '-' . $month . '-' . '31';
			$mystr =  $year . '-' . $month;

			/*Date Picker From Submit*/
			$dashboardFilter = $this->input->post();
			if (count($dashboardFilter) > 0) {
				
				$value = $dashboardFilter['value'];

				if ($value == 'today') {
					$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
					$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';
					// print_r($end_str);
					// die();

					$mon['today'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str);
					// echo $this->db->last_query();
					
					/*==========================================================
									new code percentage code
					============================================================*/
					$lastPeriod_from = date('Y-m-d', strtotime($dashboardFilter['datepicker_from'] . ' - 2 days'));
					$lastPeriod_to = date('Y-m-d', strtotime($lastPeriod_from . ' + 1 days'));
					
					$current_period = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str);
					// echo "<pre>"; print_r($current_period); die();
					
					$results = [];
					foreach($current_period as $key => $period){
						$groupId = $period['fb_group_id'];

						$previous_hit = $this->Crawler->previousPeriodCountAllRecommendationsByFilter($lastPeriod_from, $lastPeriod_to, $groupId);

						// echo "<pre>"; print_r($previous_hit); die();


							$results[$key]['ids'] = $period['ids']; 
							$results[$key]['fb_group_name'] = $period['fb_group_name'];
							
							$original = $period['ids'];						  // $original = 30						
							$current  = isset($previous_hit['groupIds']);			  // $current  = 20
	
							$diff = $original - $current;    			      // $diff = 30 - 20
							$percentChange = ($diff / $original) * 100;		  // $percentChange = (10 / 30) * 100
																			  // Ans: (0.66666666 * 100) == 66.6 %
							$results[$key]['calculation'] = $percentChange;


						
					}

					$dashbord['recommendationsgroups'] = $results;
					$dashbord['today'] = $mon['today'];
					$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str);
					$dashbord['groups'] = $this->Clients->getAllConntectedGroupp();
					$dashbord['keyword'] = $this->Clients->getAllActiveKeyword();

					// echo "<pre>"; print_r($dashbord); die();
					// echo "today";
				} elseif ($value == 'week') {
					$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
					$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';
					// print_r($end_str); die();
					// print_r($end_str);
					// die();

					$mon['lweek'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str);
					// echo $this->db->last_query();

					/*==========================================================
									new code percentage code
					============================================================*/
					$lastPeriod_from = date('Y-m-d', strtotime($dashboardFilter['datepicker_from'] . ' - 8 days'));
					$lastPeriod_to = date('Y-m-d', strtotime($lastPeriod_from . ' + 7 days'));
					
					$current_period = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str);
					// echo "<pre>"; print_r($current_period); die();
					
					$results = [];
					foreach($current_period as $key => $period){
						$groupId = $period['fb_group_id'];

						$previous_hit = $this->Crawler->previousPeriodCountAllRecommendationsByFilter($lastPeriod_from, $lastPeriod_to, $groupId);

						// echo "<pre>"; print_r($previous_hit); die();

						$results[$key]['ids'] = $period['ids']; 
						$results[$key]['fb_group_name'] = $period['fb_group_name'];
						
						$original = $period['ids'];						  // $original = 30						
						$current  = isset($previous_hit['groupIds']);			  // $current  = 20

						$diff = $original - $current;    			      // $diff = 30 - 20
						// $diff = abs($diff);
						$percentChange = ($diff / $original) * 100;		  // $percentChange = (10 / 30) * 100
																		  // Ans: (0.66666666 * 100) == 66.6 %
						$results[$key]['calculation'] = $percentChange;
						
					}

					// echo "<pre>"; print_r($results); die();


					$dashbord['recommendationsgroups'] = $results;
					$dashbord['lweek'] = $mon['lweek'];
					$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str);
					$dashbord['groups'] = $this->Clients->getAllConntectedGroupp();

					$dashbord['keyword'] = $this->Clients->getAllActiveKeyword();

					// echo "<pre>"; print_r($dashbord); die();
				} elseif ($value == 'month') {
					
					// echo "hello"; die();
					// print_r($allClintes); die();
					// print_r($clientId); die();

					$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
					$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';
					// print_r($end_str); die();

					$mon['lmonths'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str);
					// echo $this->db->last_query();

					/*==========================================================
									new code percentage code
					============================================================*/
					$lastPeriod_from = date('Y-m-d', strtotime($dashboardFilter['datepicker_from'] . ' - 31 days'));
					$lastPeriod_to = date('Y-m-d', strtotime($lastPeriod_from . ' + 30 days'));
					
					$current_period = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str);
					
					$results = [];
					foreach($current_period as $key => $period){
						$groupId = $period['fb_group_id'];

						$previous_hit = $this->Crawler->previousPeriodCountAllRecommendationsByFilter($lastPeriod_from, $lastPeriod_to, $groupId);

						$results[$key]['ids'] = $period['ids']; 
						$results[$key]['fb_group_name'] = $period['fb_group_name'];
						
						$original = $period['ids'];						  // $original = 30						
						$current  = isset($previous_hit['groupIds']);			  // $current  = 20

						$diff = $original - $current;
						// $diff = abs($diff);   			      // $diff = 30 - 20
						$percentChange = ($diff / $original) * 100;		  // $percentChange = (10 / 30) * 100
																		  // Ans: (0.66666666 * 100) == 66.6 %
						$results[$key]['calculation'] = $percentChange;
						
					}

					$dashbord['recommendationsgroups'] = $results;
					$dashbord['lmonths'] = $mon['lmonths'];
					$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str);
					$dashbord['groups'] = $this->Clients->getAllConntectedGroupp();
					$dashbord['keyword'] = $this->Clients->getAllActiveKeyword();

					// echo "<pre>"; print_r($dashbord); die();

				} elseif($value == 'custom') {
					$dateFrom = date_create($dashboardFilter['datepicker_from']);
					$dateTo = date_create($dashboardFilter['datepicker_to']);

					$countDays = date_diff($dateFrom, $dateTo);
					$days = $countDays->days;

					if ($days < 10) {
						// echo 10; die();
						$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
						$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';

						$mon['day'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str);

						$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str);
						$dashbord['recommendationsgroups'] = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str);
						$dashbord['day'] = $mon['day'];
						// echo "<pre>"; print_r($groups); die();

					} else if ($days >= 10 && $days <= 60) {
						// echo 60;
						// die();
						$start_recom = $dashboardFilter['datepicker_from'] . ' 00:00:00';
						$end_recom = $dashboardFilter['datepicker_to'] . ' 23:59:59';

						$dateFrom = date_create($dashboardFilter['datepicker_from']);
						$dateTo = date_create($dashboardFilter['datepicker_to']);

						$countDays = date_diff($dateFrom, $dateTo);
						$weeks = ceil($countDays->days / 7);

						$start_str = date('Y-m-d', strtotime($dashboardFilter['datepicker_from']));
						for ($i = 0; $i < $weeks; $i++) {
							$new_date = date('Y-m-d', strtotime($start_str . ' + 7 days'));
							$test = array('name' => 'week' . $i, 'count' => $this->Crawler->getRecommendationsChartValue($start_str, $new_date));

							$mon['weeks'][$i] = $test;
							$start_str = $new_date;
						}
						$dashbord['weeks'] = $mon['weeks'];
						$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_recom, $end_recom);
						$dashbord['recommendationsgroups'] = $this->Crawler->countAllRecommendationsByFilter($start_recom, $end_recom);
					} else {
						// echo 70; die();
						$start_recom = $dashboardFilter['datepicker_from'] . ' 00:00:00';
						$end_recom = $dashboardFilter['datepicker_to'] . ' 23:59:59';

						$dateFrom = date_create($dashboardFilter['datepicker_from']);
						$dateTo = date_create($dashboardFilter['datepicker_to']);

						$countDays = date_diff($dateFrom, $dateTo);
						$months = ceil($countDays->days / 31);

						$start_str = date('Y-m-d', strtotime($dashboardFilter['datepicker_from']));
						for ($i = 0; $i < $months; $i++) {
							$new_date = date('Y-m-d', strtotime($start_str . ' + 31 days'));
							$test = array('name' => 'month' . $i, 'count' => $this->Crawler->getRecommendationsChartValue($start_str, $new_date));

							$mon['month'][$i] = $test;
							$start_str = $new_date;
						}
						$dashbord['months'] = $mon['month'];
						$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_recom, $end_recom);
						$dashbord['recommendationsgroups'] = $this->Crawler->countAllRecommendationsByFilter($start_recom, $end_recom);
					}
					
				}





				$data['full_content'] =  $this->load->view('dashboard/dashboard-admin', $dashbord, TRUE);
			}

			$data['full_content'] =  $this->load->view('dashboard/dashboard-admin', $dashbord, TRUE);
		} elseif ($abc['account_level'] == 'ambassador') {

			$allClintes = $this->Ambassadormodel->getAllAmbsclient($abc['id']);
			$myClient =  $allClintes[0];

			if ($this->session->userdata('myClient')  != NULL) {
				$myClient =  $this->session->userdata('myClient');
			}
			$clientId = $this->Clients->getCrawlerToClientUserId($myClient);

			$dashboardFilter = $this->input->post();

			if (count($dashboardFilter) > 0) {

				$value = $dashboardFilter['value'];

				if ($value == 'today') {
					$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
					$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';
					// print_r($end_str);
					// die();

					$mon['today'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str, $clientId);
					// echo $this->db->last_query();

					/*==========================================================
									new code percentage code
					============================================================*/
					$lastPeriod_from = date('Y-m-d', strtotime($dashboardFilter['datepicker_from'] . ' - 2 days'));
					$lastPeriod_to = date('Y-m-d', strtotime($lastPeriod_from . ' + 1 days'));
					
					$current_period = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str, $clientId);
					// echo "<pre>"; print_r($current_period); die();
					
					$results = [];
					foreach($current_period as $key => $period){
						$groupId = $period['fb_group_id'];

						$previous_hit = $this->Crawler->previousPeriodCountAllRecommendationsByFilter($lastPeriod_from, $lastPeriod_to, $groupId);

						// echo "<pre>"; print_r($previous_hit); die();


							$results[$key]['ids'] = $period['ids']; 
							$results[$key]['fb_group_name'] = $period['fb_group_name'];
							
							$original = $period['ids'];						  // $original = 30						
							$current  = isset($previous_hit['groupIds']);			  // $current  = 20
	
							$diff = $original - $current;    			      // $diff = 30 - 20
							$percentChange = ($diff / $original) * 100;		  // $percentChange = (10 / 30) * 100
																			  // Ans: (0.66666666 * 100) == 66.6 %
							$results[$key]['calculation'] = $percentChange;


						
					}

					$dashbord['recommendationsgroups'] = $results;

					$dashbord['today'] = $mon['today'];
					$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
					$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($myClient);
					$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($myClient);


					// echo "<pre>"; print_r($dashbord); die();
					// echo "today";
				} elseif ($value == 'week') {
					$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
					$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';
					// print_r($end_str); die();
					// print_r($end_str);
					// die();

					$mon['lweek'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str, $clientId);
					// echo $this->db->last_query();

					/*==========================================================
									new code percentage code
					============================================================*/
					$lastPeriod_from = date('Y-m-d', strtotime($dashboardFilter['datepicker_from'] . ' - 8 days'));
					$lastPeriod_to = date('Y-m-d', strtotime($lastPeriod_from . ' + 7 days'));
					
					$current_period = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str, $clientId);
					// echo "<pre>"; print_r($current_period); die();
					
					$results = [];
					foreach($current_period as $key => $period){
						$groupId = $period['fb_group_id'];

						$previous_hit = $this->Crawler->previousPeriodCountAllRecommendationsByFilter($lastPeriod_from, $lastPeriod_to, $groupId);

						// echo "<pre>"; print_r($previous_hit); die();

						$results[$key]['ids'] = $period['ids']; 
						$results[$key]['fb_group_name'] = $period['fb_group_name'];
						
						$original = $period['ids'];						  // $original = 30						
						$current  = isset($previous_hit['groupIds']);			  // $current  = 20

						$diff = $original - $current;    			      // $diff = 30 - 20
						// $diff = abs($diff);
						$percentChange = ($diff / $original) * 100;		  // $percentChange = (10 / 30) * 100
																		  // Ans: (0.66666666 * 100) == 66.6 %
						$results[$key]['calculation'] = $percentChange;
						
					}

					// echo "<pre>"; print_r($results); die();


					$dashbord['recommendationsgroups'] = $results;

					$dashbord['lweek'] = $mon['lweek'];
					$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
					$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($myClient);

					$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($myClient);

					// echo "<pre>"; print_r($dashbord); die();
				} elseif ($value == 'month') {
					
					// echo "hello"; die();
					// print_r($allClintes); die();
					// print_r($clientId); die();

					$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
					$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';
					// print_r($end_str); die();

					$mon['lmonths'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str, $clientId);
					// echo $this->db->last_query();

					/*==========================================================
									new code percentage code
					============================================================*/
					$lastPeriod_from = date('Y-m-d', strtotime($dashboardFilter['datepicker_from'] . ' - 31 days'));
					$lastPeriod_to = date('Y-m-d', strtotime($lastPeriod_from . ' + 30 days'));
					
					$current_period = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str, $clientId);
					
					$results = [];
					foreach($current_period as $key => $period){
						$groupId = $period['fb_group_id'];

						$previous_hit = $this->Crawler->previousPeriodCountAllRecommendationsByFilter($lastPeriod_from, $lastPeriod_to, $groupId);

						$results[$key]['ids'] = $period['ids']; 
						$results[$key]['fb_group_name'] = $period['fb_group_name'];
						
						$original = $period['ids'];						  // $original = 30						
						$current  = isset($previous_hit['groupIds']);			  // $current  = 20

						$diff = $original - $current;
						// $diff = abs($diff);   			      // $diff = 30 - 20
						$percentChange = ($diff / $original) * 100;		  // $percentChange = (10 / 30) * 100
																		  // Ans: (0.66666666 * 100) == 66.6 %
						$results[$key]['calculation'] = $percentChange;
						
					}

					$dashbord['recommendationsgroups'] = $results;
					
					$dashbord['lmonths'] = $mon['lmonths'];
					$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
					$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($myClient);
					$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($myClient);

					// echo "<pre>"; print_r($dashbord); die();

				} elseif($value == 'custom') {
					// echo "custom";
					// die();

					$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
					$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';

					$dateFrom = date_create($dashboardFilter['datepicker_from']);
					$dateTo = date_create($dashboardFilter['datepicker_to']);

					$countDays = date_diff($dateFrom, $dateTo);
					$days = $countDays->days;
					// echo $days; die();

					if ($days < 10) {
						// echo 10; die();
						$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
						$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';

						$mon['day'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str, $clientId);
						// echo $this->db->last_query();

						$dashbord['recommendationsgroups'] = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str, $clientId);

						$dashbord['day'] = $mon['day'];
						$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
						$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($myClient);
						$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($myClient);

						// echo "<pre>"; print_r($dashbord); die();

					} else if ($days >= 10 && $days <= 60) {
						// echo 60;
						// die();
						$start_recom = $dashboardFilter['datepicker_from'] . ' 00:00:00';
						$end_recom = $dashboardFilter['datepicker_to'] . ' 23:59:59';

						$dateFrom = date_create($dashboardFilter['datepicker_from']);
						$dateTo = date_create($dashboardFilter['datepicker_to']);

						$countDays = date_diff($dateFrom, $dateTo);
						$weeks = ceil($countDays->days / 7);

						$start_str = date('Y-m-d', strtotime($dashboardFilter['datepicker_from']));
						for ($i = 0; $i < $weeks; $i++) {
							$new_date = date('Y-m-d', strtotime($start_str . ' + 7 days'));
							$test = array('name' => 'week' . $i, 'count' => $this->Crawler->getRecommendationsChartValue($start_str, $new_date, $clientId));

							$mon['weeks'][$i] = $test;
							$start_str = $new_date;
						}
						$dashbord['weeks'] = $mon['weeks'];
						// echo $this->db->last_query();
						$dashbord['recommendationsgroups'] = $this->Crawler->countAllRecommendationsByFilter($start_recom, $end_recom, $clientId);
						$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
						$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($myClient);
						$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($myClient);

						// echo "<pre>"; print_r($dashbord); die();

					} else {
						// echo 70; die();
						$start_recom = $dashboardFilter['datepicker_from'] . ' 00:00:00';
						$end_recom = $dashboardFilter['datepicker_to'] . ' 23:59:59';

						$dateFrom = date_create($dashboardFilter['datepicker_from']);
						$dateTo = date_create($dashboardFilter['datepicker_to']);

						$countDays = date_diff($dateFrom, $dateTo);
						$months = ceil($countDays->days / 31);

						$start_str = date('Y-m-d', strtotime($dashboardFilter['datepicker_from']));
						for ($i = 0; $i < $months; $i++) {
							$new_date = date('Y-m-d', strtotime($start_str . ' + 31 days'));
							$test = array('name' => 'month' . $i, 'count' => $this->Crawler->getRecommendationsChartValue($start_str, $new_date, $clientId));

							$mon['month'][$i] = $test;
							$start_str = $new_date;
						}
						$dashbord['months'] = $mon['month'];
						$dashbord['recommendationsgroups'] = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str, $clientId);
						$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
						$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($myClient);
						$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($myClient);
					}
				}
				// die();
				// echo "<pre>"; print_r($dashbord); die();
			}

			$data['full_content'] =  $this->load->view('dashboard/ambassador_dashbord', $dashbord, TRUE);
		} else {

			$getId = $this->session->userdata('id');
			
			if($this->session->userdata('client_id') != ''){
				$clientId = $this->session->userdata('id');
				$getMulticrawlers = $this->Clients->getAllCrawlersUnderClient($getId);
        		$id = array_column($getMulticrawlers, 'crawler_id');
			}else{
				$id = $this->session->userdata('id');
				$clientId = $this->Clients->getCrawlerToClientUserId($getId);
			}

			// echo $this->db->last_query();
			// echo "<pre>"; print_r($crawlerId); die();
			// echo "<pre>"; print_r($clientId); die();
			

			$dashboardFilter = $this->input->post();
			if (count($dashboardFilter) > 0) {
			
				$value = $dashboardFilter['value'];
				// print_r($value); die();


				if ($value == 'today') {
					$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
					$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';
					// print_r($end_str);
					// die();

					$mon['today'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str, $clientId);
					// echo $this->db->last_query();

					/*==========================================================
									new code percentage code
					============================================================*/
					$lastPeriod_from = date('Y-m-d', strtotime($dashboardFilter['datepicker_from'] . ' - 2 days'));
					$lastPeriod_to = date('Y-m-d', strtotime($lastPeriod_from . ' + 1 days'));
					
					$current_period = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str, $clientId);
					// echo "<pre>"; print_r($current_period); die();
					
					$results = [];
					foreach($current_period as $key => $period){
						$groupId = $period['fb_group_id'];

						$previous_hit = $this->Crawler->previousPeriodCountAllRecommendationsByFilter($lastPeriod_from, $lastPeriod_to, $groupId);

						// echo "<pre>"; print_r($previous_hit); die();


							$results[$key]['ids'] = $period['ids']; 
							$results[$key]['fb_group_name'] = $period['fb_group_name'];
							
							$original = $period['ids'];						  // $original = 30						
							$current  = isset($previous_hit['groupIds']);			  // $current  = 20
	
							$diff = $original - $current;    			      // $diff = 30 - 20
							$percentChange = ($diff / $original) * 100;		  // $percentChange = (10 / 30) * 100
																			  // Ans: (0.66666666 * 100) == 66.6 %
							$results[$key]['calculation'] = $percentChange;


						
					}

					$dashbord['recommendationsgroups'] = $results;

					$dashbord['today'] = $mon['today'];
					$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
					$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($id);
					$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($id);


					// echo "<pre>"; print_r($dashbord); die();
					// echo "today";
				} elseif ($value == 'week') {
					$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
					$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';
					// print_r($end_str); die();
					// print_r($end_str);
					// die();

					$mon['lweek'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str, $clientId);
					// echo $this->db->last_query();

					/*==========================================================
									new code percentage code
					============================================================*/
					$lastPeriod_from = date('Y-m-d', strtotime($dashboardFilter['datepicker_from'] . ' - 8 days'));
					$lastPeriod_to = date('Y-m-d', strtotime($lastPeriod_from . ' + 7 days'));
					
					$current_period = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str, $clientId);
					// echo "<pre>"; print_r($current_period); die();
					
					$results = [];
					foreach($current_period as $key => $period){
						$groupId = $period['fb_group_id'];

						$previous_hit = $this->Crawler->previousPeriodCountAllRecommendationsByFilter($lastPeriod_from, $lastPeriod_to, $groupId);

						// echo "<pre>"; print_r($previous_hit); die();

						$results[$key]['ids'] = $period['ids']; 
						$results[$key]['fb_group_name'] = $period['fb_group_name'];
						
						$original = $period['ids'];						  // $original = 30						
						$current  = isset($previous_hit['groupIds']);			  // $current  = 20

						$diff = $original - $current;    			      // $diff = 30 - 20
						// $diff = abs($diff);
						$percentChange = ($diff / $original) * 100;		  // $percentChange = (10 / 30) * 100
																		  // Ans: (0.66666666 * 100) == 66.6 %
						$results[$key]['calculation'] = $percentChange;
						
					}

					// echo "<pre>"; print_r($results); die();


					$dashbord['recommendationsgroups'] = $results;

					$dashbord['lweek'] = $mon['lweek'];
					$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
					$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($id);

					$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($id);

					// echo "<pre>"; print_r($dashbord); die();
				} elseif ($value == 'month') {
					
					// echo "hello"; die();
					// print_r($allClintes); die();
					// print_r($clientId); die();

					$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
					$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';
					// print_r($end_str); die();

					$mon['lmonths'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str, $clientId);
					// echo $this->db->last_query();

					/*==========================================================
									new code percentage code
					============================================================*/
					$lastPeriod_from = date('Y-m-d', strtotime($dashboardFilter['datepicker_from'] . ' - 31 days'));
					$lastPeriod_to = date('Y-m-d', strtotime($lastPeriod_from . ' + 30 days'));
					
					$current_period = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str, $clientId);
					
					$results = [];
					foreach($current_period as $key => $period){
						$groupId = $period['fb_group_id'];

						$previous_hit = $this->Crawler->previousPeriodCountAllRecommendationsByFilter($lastPeriod_from, $lastPeriod_to, $groupId);

						$results[$key]['ids'] = $period['ids']; 
						$results[$key]['fb_group_name'] = $period['fb_group_name'];
						
						$original = $period['ids'];						  // $original = 30						
						$current  = isset($previous_hit['groupIds']);			  // $current  = 20

						$diff = $original - $current;
						// $diff = abs($diff);   			      // $diff = 30 - 20
						$percentChange = ($diff / $original) * 100;		  // $percentChange = (10 / 30) * 100
																		  // Ans: (0.66666666 * 100) == 66.6 %
						$results[$key]['calculation'] = $percentChange;
						
					}

					$dashbord['recommendationsgroups'] = $results;

					$dashbord['lmonths'] = $mon['lmonths'];
					$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
					$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($id);
					$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($id);

					// echo "<pre>"; print_r($dashbord); die();

				} elseif($value == 'custom') {
					// echo "custom";
					// die();

					$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
					$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';

					$dateFrom = date_create($dashboardFilter['datepicker_from']);
					$dateTo = date_create($dashboardFilter['datepicker_to']);

					$countDays = date_diff($dateFrom, $dateTo);
					$days = $countDays->days;
					// echo $days; die();

					if ($days < 10) {
						// echo 10; die();
						$start_str = $dashboardFilter['datepicker_from'] . ' 00:00:00';
						$end_str = $dashboardFilter['datepicker_to'] . ' 23:59:59';

						$mon['day'] = $this->Crawler->getRecommendationsChartValueDay($start_str, $end_str, $clientId);
						// echo $this->db->last_query();

						$dashbord['recommendationsgroups'] = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str, $clientId);
						$dashbord['day'] = $mon['day'];
						$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
						$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($id);
						$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($id);

						// echo "<pre>"; print_r($dashbord); die();

					} else if ($days >= 10 && $days <= 60) {
						// echo 60;
						// die();
						$start_recom = $dashboardFilter['datepicker_from'] . ' 00:00:00';
						$end_recom = $dashboardFilter['datepicker_to'] . ' 23:59:59';

						$dateFrom = date_create($dashboardFilter['datepicker_from']);
						$dateTo = date_create($dashboardFilter['datepicker_to']);

						$countDays = date_diff($dateFrom, $dateTo);
						$weeks = ceil($countDays->days / 7);

						$start_str = date('Y-m-d', strtotime($dashboardFilter['datepicker_from']));
						for ($i = 0; $i < $weeks; $i++) {
							$new_date = date('Y-m-d', strtotime($start_str . ' + 7 days'));
							$test = array('name' => 'week' . $i, 'count' => $this->Crawler->getRecommendationsChartValue($start_str, $new_date, $clientId));

							$mon['weeks'][$i] = $test;
							$start_str = $new_date;
						}
						$dashbord['weeks'] = $mon['weeks'];
						// echo $this->db->last_query();
						$dashbord['recommendationsgroups'] = $this->Crawler->countAllRecommendationsByFilter($start_recom, $end_recom, $clientId);
						$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
						$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($id);
						$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($id);

						// echo "<pre>"; print_r($dashbord); die();

					} else {
						// echo 70; die();
						$start_recom = $dashboardFilter['datepicker_from'] . ' 00:00:00';
						$end_recom = $dashboardFilter['datepicker_to'] . ' 23:59:59';

						$dateFrom = date_create($dashboardFilter['datepicker_from']);
						$dateTo = date_create($dashboardFilter['datepicker_to']);

						$countDays = date_diff($dateFrom, $dateTo);
						$months = ceil($countDays->days / 31);

						$start_str = date('Y-m-d', strtotime($dashboardFilter['datepicker_from']));
						for ($i = 0; $i < $months; $i++) {
							$new_date = date('Y-m-d', strtotime($start_str . ' + 31 days'));
							$test = array('name' => 'month' . $i, 'count' => $this->Crawler->getRecommendationsChartValue($start_str, $new_date, $clientId));

							$mon['month'][$i] = $test;
							$start_str = $new_date;
						}
						$dashbord['months'] = $mon['month'];
						$dashbord['recommendationsgroups'] = $this->Crawler->countAllRecommendationsByFilter($start_str, $end_str, $clientId);
						$dashbord['request_count'] = $this->Ambassadormodel->getRecommandedRecoquest($start_str, $end_str, $clientId);
						$dashbord['groups'] = $this->Clients->getAllConntectedGroupp($id);
						$dashbord['keyword'] = $this->Clients->getAllActiveKeyword($id);
					}
				}
			}

			$data['full_content'] =  $this->load->view('dashboard/dashboard', $dashbord, TRUE);
		}

		$this->load->view('layout/master', $data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url(), 'refresh');
	}

	public function start()
	{
		$data['full_content'] =  $this->load->view('dashboard/start', '', TRUE);
		$this->load->view('layout/master', $data);
	}

	public function emailValiditeCheck()
	{
		$info = $this->input->post();
		// echo "<pre>"; print_r($info); die();
		
		$result = $this->User->getEmailValiditeCheckData($info['email']);

		if($result == true){
			echo 'error';
		}else{
			echo 'success';
		}
	}
}
