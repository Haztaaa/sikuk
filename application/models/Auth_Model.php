<?php
class Auth_model extends CI_Model
{
    public function check_login_by_email($email)
    {
        return $this->db
            ->where('email', $email)
            ->where('is_active', 1)
            ->get('users')
            ->row();
    }

    public function check_login_by_username($username)
    {
        return $this->db
            ->where('username', $username)
            ->where('is_active', 1)
            ->get('users')
            ->row();
    }
}
