<?php

if (!function_exists("user_image")) {

    function user_image($id)
    {
        $CI = &get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('users', array('id' => $id));
        return $query->row();
    }

}
