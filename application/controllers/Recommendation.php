<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recommendation extends CI_Controller
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
        $id = $this->session->userdata('id');


        $cid = $this->Recommendations->amd_id();
        if ($this->session->userdata('myClient')  != NULL) {
            $cid =  $this->session->userdata('myClient');
        }
        $allReport['tags'] = $this->Recommendations->getMyTags($cid);
        //echo $this->db->last_query();
        // $allReport['alltags'] = $this->Recommendations->getAllTags();
        // $all_tags_arr


        $allReport['clients'] =  $this->Recommendations->amd_idClientInfo($cid);

        $allReport['filtered_tags'] = '';
        $allReport['top_level_tag'] = 0;
        $allReport['recommendations'] = [];
        
        // echo '<pre>';
        // print_r($allReport);
        // die();
        
        $data['full_content'] =  $this->load->view('recommendation/index', $allReport, TRUE);
        $this->load->view('layout/master', $data);
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
                $html .= '<span class="me-2 bg-light btn btn-sm rounded-pill">' . $tag . '</span><span class="tag-comma">, </span>';
            }
        }
        return $html;
    }

    public function getFilterData()
    {
        // echo "<pre>"; print_r($_POST); die();

        $id = $this->session->userdata('id');
        // echo $id; die();

        $allClintes = $this->Ambassadormodel->getAllAmbsclient($id);
        $crawlerId = $allClintes[0];

        if ($this->session->userdata('myClient')  != NULL) {
            $crawlerId =  $this->session->userdata('myClient');
        }

        $clientId = $this->Clients->getCrawlerToClientUserId($crawlerId);
        // echo $this->db->last_query();
        // echo "<pre>"; print_r($clientId); die();

        $info = $this->input->post();

        if (count($info) > 0) {
            $this->session->set_userdata('searchInfo', $info);
        } else {
            $info = $this->session->userdata('searchInfo');
        }
        if ($info['filter_tags'][0] == 0 || $info['filter_tags'][0] == 1 || $info['filter_tags'][0] == 2 || $info['filter_tags'][0] == 3) {
            $config = array();
            $config["base_url"] = base_url() . "getrecommendation";
            $config["total_rows"] = $this->Ambassadormodel->count_all($clientId, $crawlerId);

            // echo $this->db->last_query();
            // echo "<pre>"; print_r($config["total_rows"]); die();

            $config["per_page"] = 10;
            $config["uri_segment"] = 2;
            $config['attributes'] = array('class' => 'myclass');
            $this->pagination->initialize($config);


            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $filterData["links"] = $this->pagination->create_links();

            $list = $this->Ambassadormodel->getCrawlersDatatables($config["per_page"], $page, $clientId, $crawlerId);
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

            //  echo $this->db->last_query();
            //  echo "<pre>"; print_r($data); die();

            $filterData["reports"] = $data;

            $htmldata[] = $this->load->view('recommendation/reponse/crawler-response', $filterData, true);
            echo json_encode($htmldata);
        } else {
            // echo "hi"; die();
            // echo $crawlerId; die();
            // print_r($clientId); die();
            $config = array();
            $config["base_url"] = base_url() . "getcrawlerrecommendation";
            $config["total_rows"] = $this->Ambassadormodel->count_allForCustom($clientId);

            // echo $this->db->last_query();
			// echo "<pre>"; print_r($config["total_rows"]); die();

            $config["per_page"] = 10;
            $config["uri_segment"] = 2;
            $config['attributes'] = array('class' => 'myclass');
            $this->pagination->initialize($config);

            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $filterData["links"] = $this->pagination->create_links();
            $list = $this->Ambassadormodel->get_datatablesCustom($config["per_page"], $page, $clientId);

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
                $row['keyword_id'] = $this->Ambassadormodel->getkeyWord($recommendation->keyword_id);
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


    public function recmanndedReply($id, $key_id, $post_link)
    {
        $keywords = $this->Recommendations->getkeyWordForRecommand($key_id);

        return [
            'id' => $id,
            'keywords' => $keywords,
            'post_link' => $post_link,
        ];
    }

    public function checkApi()
    {

        $cURLConnection = curl_init();

        curl_setopt($cURLConnection, CURLOPT_URL, 'http://socialdemo.com/api-add-recommendation-python-app.php?uid=6ce69d9565f4e409be6c27c2d21f2b26&email_address=joseph.u@botheros.com&author_name=Joe%20Test%20Ambassador&group_id=947147415489556&post_id=3512656332342143&post_content=hey%20any%20nurse/doctor%20mamas%20here?%20my%20husband%20and%20i&keyword_id=4940&product=%20null');
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $phoneList = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        // var_dump($phoneList);
        // $jsonArrayResponse = json_decode($phoneList);

    }

    // public function updateTag()
    // {
    //     $info = $this->input->post();
    //     $tags = join(',', $info['tags']);
    //     $rm_id = $info['rm_id'];
    //     $abc = $this->Clients->updateData('recommendations', ['tags' => $tags], 'id', $rm_id);
    //     // echo $this->db->last_query();
    //     //die();
    //     $respon =  $this->getAllTags($tags) . '<a href="javascript:void(0)" onclick="show_modal_tags(' . $rm_id . ')"></a ';
    //     echo $respon;
    //     die();
    // }


    public function updateTag()
    {

        $info = $this->input->post();

        if (array_key_exists('tags', $info)) {
            $tags = join(',', $info['tags']);
            $rm_id = $info['rm_id'];
            $abc = $this->Clients->updateData('recommendations', ['tags' => $tags], 'id', $rm_id);
        } else {
            $tags = null;
            $rm_id = $info['rm_id'];
            $abc = $this->Clients->updateData('recommendations', ['tags' => $tags], 'id', $rm_id);
        }

        $respon =  $this->getAllTags($tags) . '<a href="javascript:void(0)" onclick="show_modal_tags(' . $rm_id . ')"></a ';
        echo $respon;
        // die();
    }
}
