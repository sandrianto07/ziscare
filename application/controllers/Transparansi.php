<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transparansi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Transparansi_model');
    }

    public function index()
    {
        $periode = $this->input->get('periode', true);

        $dari = null;
        $sampai = null;

        if ($periode && preg_match('/^\d{4}-\d{2}$/', $periode)) {
            $dari = $periode . '-01';
            $sampai = date('Y-m-t', strtotime($dari));
        }

        $data = [
            'title' => 'Transparansi ZIS | MWCNU Kecamatan Ngasem',
            'description' => 'Informasi transparansi penerimaan dan penyaluran Zakat, Infaq, dan Sedekah MWCNU Kecamatan Ngasem.',
            'periode_aktif' => $periode,
            'periode_list' => $this->Transparansi_model->get_periode(),
            'ringkasan' => $this->Transparansi_model->get_ringkasan($dari, $sampai),
            'rekap_penerimaan' => $this->Transparansi_model->get_rekap_penerimaan($dari, $sampai),
            'rekap_penyaluran' => $this->Transparansi_model->get_rekap_penyaluran($dari, $sampai),
            'timeline' => $this->Transparansi_model->get_timeline($dari, $sampai, 20),
            'transaksi' => $this->Transparansi_model->get_transaksi_publik($dari, $sampai, 30)
        ];

        $this->load->view('transparansi/index', $data);
    }
}