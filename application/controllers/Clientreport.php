<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientreport extends CI_Controller {
          public function __construct()
	{
	    // Call the CI_Model constructor
	    parent::__construct();
		$this->load->model('User');
		$this->load->model('Clients');
		$this->load->model('Clientreportmodel');

	    if(! $this->session->userdata('login_state')){
            return redirect(base_url());
        }
	}

	public function index()
	{
		$data = array();

		$clientreport['error'] = '';
		$clientreport['accounts'] = $this->Clientreportmodel->getAllClients();
		$clientreport['taglists'] = $this->Clientreportmodel->getAllTagLists();
		$clientreport['endclienttags'] = $this->Clientreportmodel->getEndClientTag();
		$clientreport['clienttabledata'] = $this->Clientreportmodel->viewTableReport();


		// echo "<pre>"; print_r($clientreport['endclienttags']); die();

		
// 		$this->session->set_userdata('client_report', $clientreport);
		$data['full_content'] =  $this->load->view('clientreport/index', $clientreport, TRUE);
		$this->load->view('layout/master', $data);
	}

	public function getclinetInfo(){
		$info = $this->input->post();
		$client = $this->Clientreportmodel->getclinetInfo($info['client_id']);
		echo $client->full_name;
	}

	public function createReport()
	{
		$this->load->library('tcpdf');

		$info = $this->input->post();

		// echo "<pre>";
		// print_r($info);
		// die();

		$mydata = [];
		
		
		$has_tags = false;
		$mydata ['total_requests_distinct']= 0;
		$mydata ['total_groups_distinct']= 0;
		$total_groups_distinct = 0;

		$mydata ['tagwise'] = [];


		if($info['client_tag'] != null){
			$mydata ['total_requests_distinct'] =	$this->Clientreportmodel->recommendationsIdByTagAndData();
			$mydata ['total_groups_distinct'] =	$this->Clientreportmodel->recommendationsGroupByTagAndData();
			$tags = explode(',', $info['client_tag']);
			$tagwise = [];

			foreach($tags as $tag){
				$tagwise[$tag] = $this->Clientreportmodel->recommendationstagWiseRequest($tag);
			}
			$mydata ['tagwise'] = $tagwise;
		}else{
			$mydata ['total_groups_distinct'] =	$this->Clientreportmodel->recommendationsGroupAndData();
		}
		$mydata ['total_non_tag_distinct'] =$this->Clientreportmodel->recommendationsNonTagAndData();
		$mydata ['keywords'] =$this->Clients->getMyKeywords($info['account_id']);
		$mydata['client_reports'] = $info;

		$html = $this->load->view('clientreport/client-report', $mydata,TRUE);

		// $html =TRUE
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetTitle('GENERATE-REPORT -');
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('clientreport.pdf', 'I');
	}

	public function clientPdf()
	{
		// echo "hi"; die();
		// $this->form_validation->set_rules('client_tag', 'Client Tag', 'required');
		// $this->form_validation->set_rules('input_insight', 'Input Insight', 'required');
		// $this->form_validation->set_rules('update_improv', 'Update Improv', 'required');
		// $this->form_validation->set_rules('date_range', 'Date Range', 'required');

		// if (empty($_FILES['image_screenshots']['name'])) {
		// 	$this->form_validation->set_rules('image_screenshots', 'Image Screenshots', 'required',
		// 		array('required' => 'Please Provide 300 x 300 OR Higher Resulation Image!')
		// 	);
		// }
		
		// 	echo FCPATH . 'main_assets/uploads/'; die();

		$info = $this->input->post();

		if (isset($info) && $info != '') {
			$clientAccountId = $info['client_account_id'];
			$inputInsight = $info['input_insight'];
			$weeklyTweaks = $info['weekly_tweaks'];

			$dateRange = $info['date_range'];
			$splitDate = explode('-', $dateRange);
			$dateFrom = date('Y/m/d', strtotime($splitDate[0]));
			$dateTo = date('Y/m/d', strtotime($splitDate[1]));

			//insert image
			if (isset($_FILES['image_screenshots']['name'])) {

				// multiple image upload
				$images = [];
				$count = count($_FILES['image_screenshots']['name']);
				$this->load->library('upload');

				for ($i = 0; $i < $count; $i++) {
					if (!empty($_FILES['image_screenshots']['name'][$i])) {

						$_FILES['file']['name'] = $_FILES['image_screenshots']['name'][$i];
						$_FILES['file']['type'] = $_FILES['image_screenshots']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['image_screenshots']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['image_screenshots']['error'][$i];
						$_FILES['file']['size'] = $_FILES['image_screenshots']['size'][$i];

						$config['upload_path'] = FCPATH . 'main_assets/uploads/';
						$config['allowed_types'] = 'jpg|jpeg|png|gif';
						$config['file_name'] = rand(99, 9999) . $_FILES['image_screenshots']['name'][$i];

						$this->upload->initialize($config);

						if ($this->upload->do_upload('file')) {
							$uploadData = $this->upload->data();
							$fileName = $uploadData['file_name'];
							$images[] = $fileName;
						} else {
							echo $this->upload->display_errors();
						}
					}
				}
			}

			$data = [
				'client' => $clientAccountId,
				'date_from' => $dateFrom,
				'date_to' => $dateTo,
				'tweaks' => $weeklyTweaks,

				'insights_1' => (isset($inputInsight[0]) &&  $inputInsight[0] != '' ? $inputInsight[0] : ''),
				'insights_2' => (isset($inputInsight[1]) &&  $inputInsight[1] != '' ? $inputInsight[1] : ''),
				'insights_3' => (isset($inputInsight[2]) &&  $inputInsight[2] != '' ? $inputInsight[2] : ''),
				'insights_4' => (isset($inputInsight[3]) &&  $inputInsight[3] != '' ? $inputInsight[3] : ''),

				'image_1' => (isset($images[0]) &&  $images[0] != '' ? $images[0] : ''),
				'image_2' => (isset($images[1]) &&  $images[1] != '' ? $images[1] : ''),
				'image_3' => (isset($images[2]) &&  $images[2] != '' ? $images[2] : ''),
				'image_4' => (isset($images[3]) &&  $images[3] != '' ? $images[3] : ''),
				'image_5' => (isset($images[4]) &&  $images[4] != '' ? $images[4] : ''),
				'image_6' => (isset($images[5]) &&  $images[5] != '' ? $images[5] : ''),

				'date_created' => date('Y/m/d'),
				'active' => 1,
			];
		}

		$pdfId = $this->Clientreportmodel->insertData('client_pdfs', $data);

		$clientpdf = $this->Clientreportmodel->clientPdf($pdfId);
		
		$multiple_crawlers = $this->Clientreportmodel->multipleCrawlerl($pdfId);
		
		$crawlerId = '';
		foreach($multiple_crawlers as $multiCrawler){
			$crawlerId = $multiCrawler->crawler_id;
		}
		
		//new
		$dateFrom = $clientpdf->date_from;
		$dateTo = $clientpdf->date_to;

		// groupsmonitored
		$clientpdf->groupsmonitored = $this->Clientreportmodel->groupsMonitored($crawlerId);
		// postsreviewed
		$clientpdf->postsreviewed = $this->Clientreportmodel->postsReviewed($dateFrom, $dateTo);
		// commentsreviewed
		$clientpdf->commentsreviewed = $this->Clientreportmodel->commentsReviewed($dateFrom, $dateTo);
		// end

		$this->session->set_userdata('clientpdf_data', $clientpdf);
		$this->load->view('clientreport/weekly-report', $clientpdf);
		
		$this->session->set_flashdata('success','Report Generated Successfully');
		
		// return redirect(base_url() . 'clientreport', 'refresh');	
	}

	public function viewClientPdf($pdfId){
		$clientpdf = $this->Clientreportmodel->clientPdf($pdfId);

		$multiple_crawlers = $this->Clientreportmodel->multipleCrawlerl($pdfId);
		
		$crawlerId = '';
		foreach($multiple_crawlers as $multiCrawler){
			$crawlerId = $multiCrawler->crawler_id;
		}

		//new
		$dateFrom = $clientpdf->date_from;
		$dateTo = $clientpdf->date_to;

		// groupsmonitored
		$clientpdf->groupsmonitored = $this->Clientreportmodel->groupsMonitored($crawlerId);
		// postsreviewed
		$clientpdf->postsreviewed = $this->Clientreportmodel->postsReviewed($dateFrom, $dateTo);
		// commentsreviewed
		$clientpdf->commentsreviewed = $this->Clientreportmodel->commentsReviewed($dateFrom, $dateTo);

		$this->session->set_userdata('clientpdf_data', $clientpdf);
		$this->load->view('clientreport/weekly-report', $clientpdf);
	}

	public function generatePdf()
	{
		$this->load->library('tcpdf');
		$clientpdf = $this->session->userdata('clientpdf_data');

		$client = $clientpdf->client;
		$dateFrom = $clientpdf->date_from;
		$dateTo = $clientpdf->date_to;

		$html = $this->load->view('clientreport/generate-pdf', $clientpdf, TRUE);

		// $imagePath = include FCPATH .'main_assets/report/';
		// $image = include FCPATH .'social-referral-finder-logo-left-aligned.png';
		// include FCPATH .'./libraries/tcpdf.php';
		// $headerImage = FCPATH .'main_assets/report/social-referral-finder-logo-left-aligned.png';

		// define ('K_PATH_IMAGES', 'report/files/');
		// define ('PDF_HEADER_LOGO', $headerImage);
		// define ('PDF_HEADER_LOGO_WIDTH', 45);


		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetTitle('PERFORMANCE REPORT - ' . $client . ' ' . $dateFrom . '-' . $dateTo);

		//logo
		// $image_file = K_PATH_IMAGES. $headerImage;
		// $pdf->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false,
		// false, false);
		// $pdf->SetFont('helvetica', 'B', 20);


		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'PERFORMANCE REPORT', date('m/d/Y', strtotime($dateFrom)) . ' - ' . date('m/d/Y', strtotime($dateTo)), array(2, 50, 92), array(164, 164, 164));

		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', 20));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', 15));

		$pdf->setFooterData(array(2, 50, 92), array(2, 50, 92));
		$pdf->SetDefaultMonospacedFont('helvetica');

		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
		$pdf->SetAutoPageBreak(TRUE, 20);
		$pdf->SetFont('helvetica', '', 12);

		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('PERFORMANCE REPORT-' . $client . '_' . $dateFrom . '-' . $dateTo . '.pdf', 'I');
	}
	
	public function deleteClientReport($id){
		$updateData = [
			'active' => 0,
		];
		$this->Clientreportmodel->updateData('client_pdfs', $updateData, 'pdf_id', $id);

		$success = [
			'success' => 'Deleted Successfully',
		];
		echo json_encode($success);
	}

}
