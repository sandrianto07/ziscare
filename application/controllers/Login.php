<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->model('User_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data['title'] = 'Login Admin | ZIS Care';

        $this->load->view('login', $data);
    }

    public function proses()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules(
            'login',
            'Username atau Email',
            'trim|required',
            [
                'required' => '%s wajib diisi.'
            ]
        );

        $this->form_validation->set_rules(
            'password',
            'Password',
            'required',
            [
                'required' => '%s wajib diisi.'
            ]
        );

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata(
                'error',
                validation_errors('<div>', '</div>')
            );

            redirect('login');
        }

        $login    = trim($this->input->post('login', true));
        $password = $this->input->post('password', false);

        $user = $this->User_model->get_by_login($login);

        if (!$user) {
            $this->session->set_flashdata(
                'error',
                'Username/email atau password salah.'
            );

            redirect('login');
        }

        if ($user->status !== 'aktif') {
            $this->session->set_flashdata(
                'error',
                'Akun Anda sedang ' . $user->status . '. Silakan hubungi administrator.'
            );

            redirect('login');
        }

        if (!password_verify($password, $user->password)) {
            $attempt = (int) $user->login_attempt + 1;

            $this->User_model->update_login_attempt(
                $user->id,
                $attempt
            );

            $this->session->set_flashdata(
                'error',
                'Username/email atau password salah.'
            );

            redirect('login');
        }

        $this->User_model->update_login_data(
            $user->id,
            $this->input->ip_address()
        );

        $session_data = [
            'user_id'       => $user->id,
            'username'      => $user->username,
            'nama_lengkap'  => $user->nama_lengkap,
            'email'         => $user->email,
            'role'          => $user->role,
            'foto'          => $user->foto,
            'logged_in'     => true
        ];

        $this->session->set_userdata($session_data);

        redirect('dashboard');
    }

    public function logout()
    {
        $this->session->sess_destroy();

        redirect('login');
    }
}