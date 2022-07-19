<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daily_reports_admin_conjob extends CI_Controller
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
		$adminConjobAllClients = $this->Dailyreports->getAllAdminConjobClients();

        $mainarray = [];
        foreach ($adminConjobAllClients as $client){
			// $adminconJobs = '';

		   $adminconJobs = $this->Dailyreports->getAdminConjobClients($client->id);

			// $test = count($adminconJobs);

			foreach($adminconJobs as $multiCrawler){
				$crawlerId = $multiCrawler->crawler_id;
				// print_r($crawlerId);
			}

			// $results = array_column($result, 'crawler_id');
            // return $results;

			// for($i = 0; $i < count($adminconJobs); $i++){
			// 	print_r($adminconJobs[$i]);
			// }
			// echo "<pre>";
			// die();
			
			$client->endclients = [];
			
            if(count($adminconJobs) > 0){
                $endclients =[];
                foreach($adminconJobs as $row){
					$endclients[]= $row;
                }
                $client->endclients = $endclients;
                $mainarray[] = $client; 
            }

			// echo "<pre>";
			// print_r($mainarray);
			// die();
        }

		$adminUsersConjob = $this->Dailyreports->getAdminUsersConjob();
        
		// $today = date('Y-m-d');
		$today = "2021-07-02";
        // $getYesterday = strtotime('-1day', strtotime($today));
        $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($today) ));

		$ambassadorUsersConjob = $this->Dailyreports->getAmbassadorUsersConjob();

		$newhtml = '';
		foreach($mainarray as $myarray){
			
			$totalTriggeredPosts = $this->Dailyreports->getTotalTriggeredPosts($yesterday);

			if(count($totalTriggeredPosts) > 0){
				$newhtml .='<tr class="text-center" style="line-height: 24px;font-size: 15px; ">';
     			$newhtml .='<td><b>'.$myarray->full_name.'</b></td>';
			}

			$nameTags = [];
			foreach($ambassadorUsersConjob as $ambassadors){
				$ambassadorNameTag = $this->Dailyreports->getAmbassadorNameTag($ambassadors->full_name,$yesterday);


				if(count($ambassadorNameTag) > 0){
					$nameTags[]= $ambassadors->full_name;
				}
				// echo "<pre>";
				// print_r($ambassadorNameTag);
			}

			$totalPost = count($totalTriggeredPosts);
			$newhtml .='<td>'.$totalPost.'</td>';

			
			/*--getTaggedPost--*/
			$taggedPost = $this->Dailyreports->getTaggedPost($yesterday);
			$newhtml .='<td>'.$taggedPost.'</td>';

			/*--getNotRelatedPosts--*/
			$notRelatedPosts = $this->Dailyreports->getNotRelatedPosts($yesterday);
			$newhtml .='<td>'.$notRelatedPosts.'</td>';

			/*--getRecommended--*/
			$recommended = $this->Dailyreports->getRecommended($yesterday);
			$newhtml .='<td>'.$recommended.'</td>';

			/*--getNotTaggedPosts--*/
			$notTaggedPosts = $this->Dailyreports->getNotTaggedPosts($yesterday);

			// echo $totalPost - $taggedPost; die();
			$rsnotagpost= (int)($totalPost - $taggedPost);
			$newhtml .='<td>'.$rsnotagpost.'</td>';


			/*==========================================================================
					Now sort name tags and loop through and find those counts
			===========================================================================*/
			$newhtml .='</tr>'; 

			foreach($nameTags as $nameTag){
				$nameTagPost = $this->Dailyreports->getNameTaggedPosts($yesterday, $nameTag);
				
				$newhtml .='<tr style="line-height: 24px;font-size: 15px; ">'; 
				$newhtml .='<td style="text-align:right;">'.$nameTag.'</td>';
				$newhtml .='<td>'.$nameTagPost.'</td>';

				$nameTagNotRelPost = $this->Dailyreports->getNameTagNotRelatedPosts($yesterday, $nameTag);
				$newhtml .='<td>'.$nameTagNotRelPost.'</td>';

				$nameTagRecom = $this->Dailyreports->getNameTagRecommended($yesterday, $nameTag);
				$newhtml .='<td>'.$nameTagRecom.'</td>';

				$notNameTagPost = $this->Dailyreports->getNotNameTaggedPosts($yesterday, $nameTag);
				$newhtml .='<td>'.$notNameTagPost.'</td>';

				// echo $nameTagPost;
				// echo $nameTagNotRelPost;
				// die();


				// $rsnotagpost= (int)('3' - '1');
				$rsnotagpost= (int)($nameTagPost - $nameTagNotRelPost);
				if($rsnotagpost == 0){
					$newhtml .='<td>N/A</td>';   
				}else{
					// $newhtml .='<td>'.$rsnotagpost.'</td>';   
				}
				$newhtml .='</tr>';

				// echo "<pre>";
				// print_r($notNameTagPost);
			}


		}

		

		$html = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Trigger & Tag Report</title></head><body><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><tbody><tr><td align="center"><table class="col-600" width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><tbody><tr><td align="center" valign="top"><table class="col-600" width="800px" border="0" align="center"cellpadding="0" cellspacing="0"><tr><td align="left" style="height: 200px;"><img style="display:block; font-size:0px; border:0px;"src="https://aptest.therssoftware.com/admin_proj/img/social-referral-finder-logo-left-aligned.png"width="320" alt="logo"></td></tr><tr style=" height: 30px;"><td style="display:block;margin: 0;line-height: 0; height: 30px;"><h2><b>Trigger & Tag Report For: '.$yesterday.'</b></h2></td></tr><tr style="display:block;margin: 0;line-height: 0; text-align: center;"><table class="col-600" width="800px" style=" text-align: center;"><thead><tr><td style="background-color: black;color: white;padding: 10px 0; font-size: 14px;">Account</td><td style="background-color: black;color: white;padding: 10px 0;font-size: 14px;"> Total Triggered Posts</td><td style="background-color: black;color: white;padding: 10px 0;font-size: 14px;">Tagged post</td><td style="background-color: black;color: white;padding: 10px 0;font-size: 14px;">Not Rel Posts</td><td style="background-color: black;color: white;padding: 10px 0;font-size: 14px;">Recommended</td><td style="background-color: black;color: white;padding: 10px 0;font-size: 14px;">Not tagged Posts</td></tr></thead><tbody>'.$newhtml.'</tbody></table></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></body></html>';
		
		echo $html;
		die();


		foreach($adminUsersConjob as $adminUsers){
			$subject = 'Trigger & Tag Report For: '.date('d-m-Y');
			$check = rs_send_email($adminUsers->email, $subject, $html);

			echo "<pre>";
			print_r($check);

		}
		die();









	}
}
