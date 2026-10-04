<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $this->load->model('Laporan_model');
        $this->load->model('Dashboard_model');

        $this->user_id = $this->session->userdata('user_id');
        $this->user = $this->Dashboard_model->get_user($this->user_id);
    }

    public function index() {
        $bulan = $this->input->get('bulan', true);
        $tahun = $this->input->get('tahun', true);

        if ($this->input->get('reset') === '1') {
            $this->session->unset_userdata(['laporan_bulan', 'laporan_tahun']);
            redirect('laporan');
        }

        if ($this->input->get('bulan') !== null || $this->input->get('tahun') !== null) {
            $this->session->set_userdata([
                'laporan_bulan' => $bulan,
                'laporan_tahun' => $tahun ?: date('Y')
            ]);
        } else {
            $bulan = $this->session->userdata('laporan_bulan');
            $tahun = $this->session->userdata('laporan_tahun') ?: date('Y');
        }

        $data = [
            'title' => 'Laporan | ZIS Care',
            'page_title' => 'Laporan',
            'user' => $this->user,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'total_penerimaan' => $this->Laporan_model->get_total_penerimaan($bulan, $tahun),
            'total_penyaluran' => $this->Laporan_model->get_total_penyaluran($bulan, $tahun),
            'total_mustahik' => $this->Laporan_model->get_total_mustahik(),
            'penerimaan_zakat' => $this->Laporan_model->get_total_penerimaan($bulan, $tahun, 'Zakat'),
            'penerimaan_infaq' => $this->Laporan_model->get_total_penerimaan($bulan, $tahun, 'Infaq'),
            'penerimaan_sedekah' => $this->Laporan_model->get_total_penerimaan($bulan, $tahun, 'Sedekah'),
            'penyaluran_zakat' => $this->Laporan_model->get_total_penyaluran($bulan, $tahun, 'Zakat'),
            'penyaluran_infaq' => $this->Laporan_model->get_total_penyaluran($bulan, $tahun, 'Infaq'),
            'penyaluran_sedekah' => $this->Laporan_model->get_total_penyaluran($bulan, $tahun, 'Sedekah'),
            'penerimaan_bulanan' => $this->Laporan_model->get_penerimaan_bulanan($tahun),
            'penyaluran_bulanan' => $this->Laporan_model->get_penyaluran_bulanan($tahun)
        ];

        $data['saldo_zis'] = $data['total_penerimaan'] - $data['total_penyaluran'];

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('layout/footer');
    }

    public function penerimaan()
    {
        $filters = $this->_get_filters();

        $data = [
            'title' => 'Laporan Penerimaan | ZIS Care',
            'page_title' => 'Laporan Penerimaan ZIS',
            'user' => $this->user,
            'filters' => $filters,
            'data_penerimaan' => $this->Laporan_model->get_laporan_penerimaan($filters),
            'total_penerimaan' => $this->Laporan_model->get_total_penerimaan(
                $filters['bulan'],
                $filters['tahun'],
                $filters['jenis_zis'],
                $filters['tanggal_mulai'],
                $filters['tanggal_selesai']
            )
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('laporan/penerimaan', $data);
        $this->load->view('layout/footer');
    }

    public function penyaluran()
    {
        $filters = $this->_get_filters();

        $data = [
            'title' => 'Laporan Penyaluran | ZIS Care',
            'page_title' => 'Laporan Penyaluran ZIS',
            'user' => $this->user,
            'filters' => $filters,
            'data_penyaluran' => $this->Laporan_model->get_laporan_penyaluran($filters),
            'total_penyaluran' => $this->Laporan_model->get_total_penyaluran(
                $filters['bulan'],
                $filters['tahun'],
                $filters['jenis_zis'],
                $filters['tanggal_mulai'],
                $filters['tanggal_selesai']
            )
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('laporan/penyaluran', $data);
        $this->load->view('layout/footer');
    }

    public function mustahik() {
        $filters = $this->_get_mustahik_filters();

        $data = [
            'title' => 'Laporan Mustahik | ZIS Care',
            'page_title' => 'Laporan Data Mustahik',
            'user' => $this->user,
            'filters' => $filters,
            'data_mustahik' => $this->Laporan_model->get_laporan_mustahik($filters),
            'total_mustahik' => $this->Laporan_model->get_total_mustahik($filters),
            'mustahik_aktif' => $this->Laporan_model->get_total_mustahik($filters, 'aktif'),
            'mustahik_nonaktif' => $this->Laporan_model->get_total_mustahik($filters, 'tidak_aktif')
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('laporan/mustahik', $data);
        $this->load->view('layout/footer');
    }

    public function cetak_penerimaan()
    {
        $filters = $this->_get_filters();

        $data = [
            'title' => 'Laporan Penerimaan ZIS',
            'filters' => $filters,
            'data_penerimaan' => $this->Laporan_model->get_laporan_penerimaan($filters),
            'total_penerimaan' => $this->Laporan_model->get_total_penerimaan(
                $filters['bulan'],
                $filters['tahun'],
                $filters['jenis_zis'],
                $filters['tanggal_mulai'],
                $filters['tanggal_selesai']
            )
        ];

        $this->load->view('laporan/cetak_penerimaan', $data);
    }

    public function cetak_penyaluran()
    {
        $filters = $this->_get_filters();

        $data = [
            'title' => 'Laporan Penyaluran ZIS',
            'filters' => $filters,
            'data_penyaluran' => $this->Laporan_model->get_laporan_penyaluran($filters),
            'total_penyaluran' => $this->Laporan_model->get_total_penyaluran(
                $filters['bulan'],
                $filters['tahun'],
                $filters['jenis_zis'],
                $filters['tanggal_mulai'],
                $filters['tanggal_selesai']
            )
        ];

        $this->load->view('laporan/cetak_penyaluran', $data);
    }

    public function cetak_mustahik()
    {
        $filters = $this->_get_mustahik_filters();

        $data = [
            'title' => 'Laporan Data Mustahik',
            'filters' => $filters,
            'data_mustahik' => $this->Laporan_model->get_laporan_mustahik($filters),
            'total_mustahik' => $this->Laporan_model->get_total_mustahik($filters)
        ];

        $this->load->view('laporan/cetak_mustahik', $data);
    }

    private function _get_filters()
    {
        return [
            'bulan' => $this->input->get('bulan', true),
            'tahun' => $this->input->get('tahun', true),
            'jenis_zis' => $this->input->get('jenis_zis', true),
            'tanggal_mulai' => $this->input->get('tanggal_mulai', true),
            'tanggal_selesai' => $this->input->get('tanggal_selesai', true)
        ];
    }

    private function _get_mustahik_filters() {
        return [
            'kategori' => $this->input->get('kategori', true),
            'status' => $this->input->get('status', true),
            'desa' => $this->input->get('desa', true),
            'kecamatan' => $this->input->get('kecamatan', true),
            'tanggal_mulai' => $this->input->get('tanggal_mulai', true),
            'tanggal_selesai' => $this->input->get('tanggal_selesai', true)
        ];
    }
}