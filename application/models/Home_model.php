<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model
{
    public function get_total_penerimaan()
    {
        return (float) $this->db
            ->select_sum('nominal')
            ->get('penerimaan_zis')
            ->row()
            ->nominal;
    }

    public function get_total_penyaluran()
    {
        return (float) $this->db
            ->select_sum('nominal')
            ->where('status', 'tersalurkan')
            ->get('penyaluran_zis')
            ->row()
            ->nominal;
    }

    public function get_total_zakat()
    {
        return (float) $this->db
            ->select_sum('nominal')
            ->where('jenis_zis', 'zakat')
            ->get('penerimaan_zis')
            ->row()
            ->nominal;
    }

    public function get_total_infaq()
    {
        return (float) $this->db
            ->select_sum('nominal')
            ->where('jenis_zis', 'infaq')
            ->get('penerimaan_zis')
            ->row()
            ->nominal;
    }

    public function get_total_sedekah()
    {
        return (float) $this->db
            ->select_sum('nominal')
            ->where('jenis_zis', 'sedekah')
            ->get('penerimaan_zis')
            ->row()
            ->nominal;
    }

    public function get_total_program()
    {
        return (int) $this->db
            ->where('status', 'tersalurkan')
            ->count_all_results('penyaluran_zis');
    }

    public function get_transparansi()
    {
        $penerimaan = $this->get_total_penerimaan();
        $penyaluran = $this->get_total_penyaluran();

        return [
            'total_penerimaan' => $penerimaan,
            'total_penyaluran' => $penyaluran,
            'saldo' => $penerimaan - $penyaluran
        ];
    }
}