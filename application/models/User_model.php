<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $table = 'users';

    public function get_by_login($login)
    {
        return $this->db
            ->where('username', $login)
            ->or_where('email', $login)
            ->where('deleted_at IS NULL', null, false)
            ->limit(1)
            ->get($this->table)
            ->row();
    }

    public function update_login_data($id, $ip)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, [
                'last_login'    => date('Y-m-d H:i:s'),
                'last_login_ip' => $ip,
                'login_attempt' => 0,
                'locked_until'  => null
            ]);
    }

    public function update_login_attempt($id, $attempt)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, [
                'login_attempt' => $attempt
            ]);
    }
}