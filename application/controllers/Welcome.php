<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
	    // Call the CI_Model constructor
	    parent::__construct();
	    $this->load->model('User');
		$this->load->model('Clients');
		$this->load->model('Crawler');
	    $this->load->helper('string');
		$this->load->helper('rs_email_helper');
		$this->load->library('email');
	   
	}



	public function index()
	{
		if($this->session->userdata('login_state')){
			return redirect(base_url('dashboard'));
		}else{
			$this->load->view('auth/login');
		}
	}


	public function loginsubmit()
	{
		$username = $this->input->post('email');
		$password = md5($this->input->post('password'));
		$result = $this->User->check_login('users', $username, $password);
		

		$data = [];
		if($result){

		if($result->account_level == 'client'){
         $client_id = $this->User->getClientId($result->id);
           $data['client_id'] =$client_id->end_client_id;
        }

		$data['login_state'] = 'yes';
		$data['id'] = $result->id;
		$data['email'] = $result->email;
		$data['full_name'] = $result->full_name;
		$data['account_level'] = $result->account_level;
		$this->session->set_userdata($data);	
		redirect(base_url() . 'dashboard', 'refresh');	
		}else{
		$this->session->set_flashdata('message','Email OR Password not match');
		redirect(base_url());	
		}
	}
	
	//reset password
	public function forgotPass()
	{
		$data = array();

		$info = $this->input->post();
		if(count($info) > 0){
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			if ($this->form_validation->run() == false) {
				// redirect(base_url().'forgot_pass', 'refresh');
				// $data['validation'] = validation_errors();
				// print_r($data); die();
			} else {
				$email = $this->input->post('email');
                $getUser = $this->User->getUsers('users', $email);

				if($getUser){
					// echo 'hi'; die();
					$id = $getUser->id;
					$token = random_string('alnum', 8);
					$passToken = [
						'password_uid' => $token,
					];

                	$this->User->updateData('users', $passToken, 'id', $id);

					// mail code
                    $email = $getUser->email;

                    echo $emailSubject = "Password Reset - Social Referral Finder";

					$emailBody = "";
					$emailBody .= "<p>To reset your password click on the link below:</p>";
					$password_reset_link = base_url() . 'reset_pass/' . $token;
					$emailBody .= "<p><a href='" . $password_reset_link . "'>" . $password_reset_link . "</a></p>";
					echo $emailBody .= "<p>Social Referral Finder</p>";

				// 	die();

                    $check = rs_send_email($email, $emailSubject, $emailBody);

					// echo "<pre>";
					// print_r($check);
					// die();

					$data['success'] = '<div class="alert alert-success text-center">We are sending password reset link to your email please check!</div>';
				}else {
                    $data['error'] = '<div class="alert alert-warning text-center">Email Does Not Match!</div>';
                }
			}
		}
		$this->load->view('auth/forgot-pass', $data);
	}

	public function resetPass($userToken){
		$getToken = $this->User->getMatchToken('users', $userToken);

		$data['token'] = $getToken['password_uid'];
		
		// echo "<pre>";
		// print_r($getToken);
		// die();

		if($getToken){
			$info = $this->input->post();
			if(count($info) > 0){
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'trim|required');
				if ($this->form_validation->run() == false) {
					// redirect(base_url().'forgot_pass', 'refresh');
					// $data['validation'] = validation_errors();
					// print_r($data); die();
					// echo "error"; die();
				} else {
					// echo "success"; die();
					$pass = $this->input->post('password');
					$repass = $this->input->post('confirm_pass');

					if(strlen($pass == $repass)){
						$passUpdate = [
                            'password' => md5($this->input->post('user_pass')),
                            'password_uid' => '',
                        ];

						$this->User->updateData('users', $passUpdate, 'password_uid', $userToken);

						$data['success'] = 'Password update successfully!';
					}else {
                        $data['error'] = 'Password and confirm password does not match!';
                    }
				}
			}

			$this->load->view('auth/reset-pass', $data);

		}else {
            $data['invalidToken'] = 'Invalid Token!';
            $this->load->view('auth/invalid-token', $data);
        }
			
		// echo "<pre>";
		// print_r($getToken);
		// die();

	}
	public function userSignUp(){
		
		$info = $this->input->post();

		$clinets = [];
		$clinets['allClinets'] = $this->Clients->getAllClient();
		$clinets['crawlers'] = $this->Clients->getAllCrawler();

		if(count($info) > 0){
			$this->form_validation->set_rules('crawler_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('crawler_email', 'Client Name', 'trim|required|valid_email');
			$this->form_validation->set_rules('crawler_password', 'Password', 'trim|required');

			if ($this->form_validation->run() == false) {
				// redirect(base_url().'forgot_pass', 'refresh');
				// $data['validation'] = validation_errors();
				// print_r($data); die();
				// echo "error"; die();
			} else {
				$crawlerName = $info['crawler_name'];
				$crawlerEmail = $info['crawler_email'];
				$crawlerPassword = $info['crawler_password'];

				$crawlerdata =[
					'full_name'=> $crawlerName,
					'email'=> $crawlerEmail,
					'unique_identifier'=> '',
					'password'=> md5($crawlerPassword),
					'account_level'=> 'client',
					'current_plan'=> '',
					'active'=> 1
				];

				$id = $this->Crawler->insertData('users',$crawlerdata);

				$crawler = $this->User->getCrawlersData($id);

				$email = $crawler->email;
				echo $emailSubject = "New User Registration - Social Referral Finder";

				$emailBody = "";
				$emailBody .= "<p>Hi '".$crawler->full_name."'</p>";
				$emailBody .= "<p>Welcome to social referral finder.</p>";
				$emailBody .= "<p>Thanks &amp; Regards,</p>";
				echo $emailBody .= "<p>Social Referral Finder</p>";

				$check = rs_send_email($email, $emailSubject, $emailBody);
				
				$clinets = [
					'success' => 'Successfully registation completed!'
				];
				
				// redirect(base_url() . 'signup', 'refresh');
				// echo "<pre>";
				// print_r($data);
				// die();
			}
		}
		$this->load->view('auth/sign-up', $clinets);
	}
	

}
