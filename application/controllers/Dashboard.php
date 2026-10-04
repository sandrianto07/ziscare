<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $this->load->model('Dashboard_model');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');

        $user = $this->Dashboard_model->get_user($user_id);

        $bulan = $this->input->get('bulan', TRUE);
        $tahun = $this->input->get('tahun', TRUE);

        if ($bulan !== null) {
            if ($bulan !== 'all' && !preg_match('/^(0[1-9]|1[0-2])$/', $bulan)) {
                $bulan = date('m');
            }

            $this->session->set_userdata('dashboard_bulan', $bulan);
        } else {
            $bulan = $this->session->userdata('dashboard_bulan') ?? date('m');
        }

        if ($tahun !== null) {
            if (!preg_match('/^\d{4}$/', $tahun)) {
                $tahun = date('Y');
            }

            $this->session->set_userdata('dashboard_tahun', $tahun);
        } else {
            $tahun = $this->session->userdata('dashboard_tahun') ?? date('Y');
        }

        $data = [
            'user' => $user,
            'bulan_filter' => $bulan,
            'tahun_filter' => $tahun,
            'tahun_list' => $this->Dashboard_model->get_tahun_transaksi(),
            'statistik' => $this->Dashboard_model->get_statistik($bulan, $tahun),
            'total_zakat' => $this->Dashboard_model->get_total_penerimaan_by_jenis('zakat', $bulan, $tahun),
            'total_infaq' => $this->Dashboard_model->get_total_penerimaan_by_jenis('infaq', $bulan, $tahun),
            'total_sedekah' => $this->Dashboard_model->get_total_penerimaan_by_jenis('sedekah', $bulan, $tahun),
            'jumlah_zakat' => $this->Dashboard_model->get_jumlah_penerimaan_by_jenis('zakat', $bulan, $tahun),
            'jumlah_infaq' => $this->Dashboard_model->get_jumlah_penerimaan_by_jenis('infaq', $bulan, $tahun),
            'jumlah_sedekah' => $this->Dashboard_model->get_jumlah_penerimaan_by_jenis('sedekah', $bulan, $tahun),
            'penerimaan_bulanan' => $this->Dashboard_model->get_penerimaan_bulanan($bulan, $tahun),
            'penyaluran_bulanan' => $this->Dashboard_model->get_penyaluran_bulanan($bulan, $tahun),
            'penerimaan_terbaru' => $this->Dashboard_model->get_penerimaan_terbaru($bulan, $tahun),
            'penyaluran_terbaru' => $this->Dashboard_model->get_penyaluran_terbaru($bulan, $tahun),
            'mustahik_terbaru' => $this->Dashboard_model->get_mustahik_terbaru()
        ];

        $this->load->view('dashboard/index', $data);
    }

    public function reset_filter() {
        $this->session->unset_userdata([
            'dashboard_bulan',
            'dashboard_tahun'
        ]);

        redirect('dashboard');
    }
}