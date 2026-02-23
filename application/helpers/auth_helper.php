<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('cek_login')) {

    function cek_login()
    {
        $CI = &get_instance();

        if (!$CI->session->userdata('logged_in')) {

            // optional: pesan flashdata
            $CI->session->set_flashdata('error', 'Silakan login terlebih dahulu');

            redirect('auth');
        }
    }
}
