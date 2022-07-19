<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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


function checkRequestByKeyWordId($id){
   //return $id;
   $CI=& get_instance();
   $CI->load->database();
   $query = $CI->db->get_where('recommendations', array('keyword_id' => $id));
   if($query->num_rows() > 0){
      return $query->num_rows();
   } else {
      return 0;
   }
}

function checkRequestByClawerId($gid,$id){
   $CI=& get_instance();
   $CI->load->database();
   $query = $CI->db->get_where('recommendations', array('fb_group_id' => $gid,'crawler_id' => $id));
   if($query->num_rows() > 0){
      return $query->num_rows();
   } else {
      return 0;
   }

}

function getUser($id){

   $CI=& get_instance();
   $CI->load->database();
   $query = $CI->db->get_where('users', array('id' => $id));
   if($query->num_rows() > 0){
      $row = $query->row(); 
      //$str =  "<span class='badge bg-info'>" . $row->full_name . "</span><span class='tag-comma'>, </span>";
      return $row->full_name;
   } else {
      return 0;
   }
}


// function getFacebookGroup($group_id){

//    $CI=& get_instance();
//    $CI->load->database();
//    $query = $CI->db->get_where('groups', array('fb_group_id' => $group_id));
//    if($query->num_rows() > 0){
//       $row = $query->row(); 
//       $str =  "<a class='link-primary' target='_blank' href='https://www.facebook.com/groups/" . $group_id . "'>" . $row->fb_group_name . "</a>";
//       return $str;
//    } else {
//       return 0;
//    }

// }

// function getAllTags($tags){

//    $CI=& get_instance();
//    $CI->load->database();
//    if($tags =='' || $tags == null){
//       return '';
//    }

//    $tags =  explode(',',$tags);

//    $html = '';
// foreach($tags as $tag){
//    if($tag !=''){
//       $html .= "<span class='badge bg-primary'>" . $tag . "</span><span class='tag-comma'>, </span>";

//    }
// }
// return $html;

// }