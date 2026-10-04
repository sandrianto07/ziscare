<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Home_model');
    }

    public function index()
    {
        $transparansi = $this->Home_model->get_transparansi();

        $data = [
            'title' => 'ZISCare - Transparansi Pengelolaan ZIS',
            'description' => 'Platform transparansi pengelolaan Zakat, Infaq, dan Sedekah yang mudah, terbuka, dan terpercaya.',

            'total_dana' => $transparansi['saldo'],
            'total_penerimaan' => $transparansi['total_penerimaan'],
            'total_penyaluran' => $transparansi['total_penyaluran'],

            'total_zakat' => $this->Home_model->get_total_zakat(),
            'total_infaq' => $this->Home_model->get_total_infaq(),
            'total_sedekah' => $this->Home_model->get_total_sedekah(),
            'total_program' => $this->Home_model->get_total_program()
        ];

        $this->load->view('home/index', $data);
    }
}