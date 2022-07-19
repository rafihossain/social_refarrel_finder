<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daily_reports_conjob extends CI_Controller
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
		$this->load->model('User');
		$this->load->model('Ambassadormodel');
		$this->load->model('Crawler');
		$this->load->model('Dailyreports');
		$this->load->helper('checkrequest');
		$this->load->library("pagination");
        $this->load->helper('string');
		$this->load->helper('rs_email_helper');
		$this->load->library('email');

		if (!$this->session->userdata('login_state')) {
			return redirect(base_url());
		}
	}


	public function index()
	{
		$triggeredUsers = $this->User->getAllUsers();
        
        $today = date('Y-m-d');
        $getYesterday = strtotime('-1day', strtotime($today));

        // $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($today) ));
        $yesterday = '2022-03-22';
        // echo "<pre>"; print_r($triggeredUsers[0]->id); die();

        foreach($triggeredUsers as $triggeredUser){
            // print_r($triggeredUser); die();

            $countResults = $this->Dailyreports->getDataFromReports($triggeredUser->id, $today);
            // print_r($countResults); die();
            if($countResults == 0){
            
                $mailBody = "";
                echo $mailSubject = "SRF Daily Report for " . $yesterday;

                $mailBody .= "<h2> SRF Daily Report for " . $yesterday . "</h2>";
                $mailBody .= "<p>Account: " . $triggeredUser->full_name . " (" . $triggeredUser->email . ")</p>";
                
                $totalRequests = $this->Dailyreports->recommendationsTotalRequest($yesterday, $triggeredUser->id);
                $totalRequestsNoTags = $this->Dailyreports->recommendationsTotalRequestNoTag($yesterday, $triggeredUser->id);
                
                $mailBody .= "<p>Total requests: " . $totalRequests . "</p>";
                $mailBody .= "<p>Total requests without tags: " . $totalRequestsNoTags . "</p>";
                
                $getAllTags = $this->Dailyreports->getTagForthisUser($triggeredUser->id);
                
                $requestsFoundInTags = 0;
                foreach($getAllTags as $getAllTag){
                    $tagRequests = $this->Dailyreports->recommendationsQueryByTag($yesterday, $triggeredUser->id, $getAllTag->tag);

                    // echo $tagRequests;

                    if($tagRequests > 0){
                        
                        if ($requestsFoundInTags == 0){
                            $requestsFoundInTags = 1;
                            $mailBody .= "<h3>Requests by tags</h3>";
                        }

                        $mailBody .= "<p><strong>" . $getAllTag->tag . ":</strong>" . $tagRequests . "</p>";
                    }
                // echo "<pre>"; print_r($tagRequests); die();

                }

                $mailBody .= "<p>You can disable notifications for daily reports from your account via the <strong>Notification Settings</strong> tab.</p>";
		        echo $mailBody .= "<p>Social Referral Finder</p>";

                // die();

                $check = rs_send_email($triggeredUser->email, $mailSubject, $mailBody);

                $dailyReports = [
                    'user_id' => $triggeredUser->id,
                    'send_date' => $today
                ];
                
                $this->Dailyreports->insertData('daily_reports', $dailyReports);

                // echo "<pre>";
                // print_r($dailyReports);
                // die();

            }


        }
        // die();
	}
}
