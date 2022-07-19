<?php

if (!function_exists("rs_send_email")) {

    function rs_send_email($toEmail, $emailSubject, $emailBody)
    {
        $CI = &get_instance();

        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'mail.therssoftware.com',
            'smtp_user' => 'newest@therssoftware.com',
            'smtp_pass' => 'PLJZQwjHq2b%',
            'smtp_port' => 465,
            'smtp_crypto' => 'ssl',
            'mailType' => 'html',
        ];

        $CI->email->initialize($config);

        $CI->email->from("newest@therssoftware.com", 'Rafi Hossain');
        $CI->email->to($toEmail);

        $CI->email->subject($emailSubject);
        $CI->email->message($emailBody);

        $CI->email->send();

        if (!$CI->email->send()) {
            return $CI->email->print_debugger();
        } else {
            return true;
        }
    }

}
