<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */


function getAllCrawlerUnderClient($id, $set = 0)
{
   $CI = &get_instance();
   $CI->load->database();

   $CI->db->select('crawler_id');
   $CI->db->from('multiple_crawler');
   $CI->db->where('end_client_id', $id);
   $query_result = $CI->db->get();
   $result = $query_result->result_array();
   //echo $CI->db->last_query();
   if (count($result) > 0) {
      for ($i = 0; $i < count($result); $i++) {
         $CI->db->select('users.full_name');
         $CI->db->from('users');
         $CI->db->where('users.id', $result[$i]['crawler_id']);
         $query_result = $CI->db->get();
         $rows = $query_result->row();
         $result[$i]['full_name'] = $rows->full_name;
      }
   }

   // print_r($result);
   // die();

   $fullName = array_column($result, 'full_name');
   $join = join(", ", $fullName);

   if ($set == 1) {
      echo  $join;
      die();
   }

   // if (str_word_count($join) > 0) {
   //    echo $join .'...<span><a href="javascript:;" data-id="'.$id.'" class="text-danger modalBtn">read more</a></span>';      
   // } else {
   //    echo "Unassigned";
   // }

   $str = 'Unassigned';

   if (count($fullName) > 0) {
      $str = $fullName[0];
      if (count($fullName) > 1) {
         $str  = $str . '...<span><a href="javascript:;" data-id="' . $id . '" class="text-danger modalBtn">read more</a></span>'; ?>
<?php }
   }


   echo $str;

   // echo "<pre>"; echo $join; die();
   // return $join;


}



function assignedClientListInCrawler($id)
{
   $CI = &get_instance();
   $CI->load->database();

   $CI->db->select('*');
   $CI->db->from('multiple_crawler');
   $CI->db->where('crawler_id', $id);
   $query_result = $CI->db->get();
   $result = $query_result->result_array();
   $allClients = array_column($result, 'crawler_id');

   if (count($allClients) > 0) {
      echo count($allClients);
   } else {
      echo '0';
   }
}
function totalConnectedGroupsInCrawler($id)
{
   $CI = &get_instance();
   $CI->load->database();

   $CI->db->select('*');
   $CI->db->from('groups');
   $CI->db->where('crawler_id', $id);
   $query_result = $CI->db->get();
   $result = $query_result->result_array();
   $allClients = array_column($result, 'crawler_id');

   if (count($allClients) > 0) {
      echo count($allClients);
   } else {
      echo '0';
   }
}

