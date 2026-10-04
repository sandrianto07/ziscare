<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    public function get_user($user_id) {
        return $this->db
            ->where('id', $user_id)
            ->get('users')
            ->row_array();
    }

    private function filter_tanggal($bulan, $tahun) {
        if ($bulan !== 'all') {
            $this->db->where('MONTH(tanggal)', (int) $bulan);
        }

        $this->db->where('YEAR(tanggal)', (int) $tahun);
    }

    public function get_statistik($bulan, $tahun) {
        $this->filter_tanggal($bulan, $tahun);

        $penerimaan = $this->db
            ->select('
                COALESCE(SUM(nominal), 0) AS total_penerimaan,
                COUNT(*) AS jumlah_penerimaan
            ')
            ->get('penerimaan_zis')
            ->row();

        $this->filter_tanggal($bulan, $tahun);

        $penyaluran = $this->db
            ->select('
                COALESCE(SUM(nominal), 0) AS total_penyaluran,
                COUNT(*) AS jumlah_penyaluran
            ')
            ->get('penyaluran_zis')
            ->row();

        $mustahik = $this->db
            ->select("
                COUNT(*) AS total_mustahik,
                SUM(CASE WHEN status = 'aktif' THEN 1 ELSE 0 END) AS mustahik_aktif,
                SUM(CASE WHEN status != 'aktif' OR status IS NULL THEN 1 ELSE 0 END) AS mustahik_tidak_aktif
            ")
            ->get('mustahik')
            ->row();

        return [
            'total_penerimaan' => (float) ($penerimaan->total_penerimaan ?? 0),
            'jumlah_penerimaan' => (int) ($penerimaan->jumlah_penerimaan ?? 0),
            'total_penyaluran' => (float) ($penyaluran->total_penyaluran ?? 0),
            'jumlah_penyaluran' => (int) ($penyaluran->jumlah_penyaluran ?? 0),
            'total_mustahik' => (int) ($mustahik->total_mustahik ?? 0),
            'mustahik_aktif' => (int) ($mustahik->mustahik_aktif ?? 0),
            'mustahik_tidak_aktif' => (int) ($mustahik->mustahik_tidak_aktif ?? 0),
            'penerimaan_dibatalkan' => 0,
            'penyaluran_dibatalkan' => 0
        ];
    }

    public function get_total_penerimaan_by_jenis($jenis_zis, $bulan, $tahun) {
        $this->filter_tanggal($bulan, $tahun);

        $result = $this->db
            ->select_sum('nominal')
            ->where('LOWER(jenis_zis)', strtolower($jenis_zis))
            ->get('penerimaan_zis')
            ->row();

        return (float) ($result->nominal ?? 0);
    }

    public function get_jumlah_penerimaan_by_jenis($jenis_zis, $bulan, $tahun) {
        $this->filter_tanggal($bulan, $tahun);

        return (int) $this->db
            ->where('LOWER(jenis_zis)', strtolower($jenis_zis))
            ->count_all_results('penerimaan_zis');
    }

    public function get_penerimaan_bulanan($bulan, $tahun) {
        $this->filter_tanggal($bulan, $tahun);

        return $this->db
            ->select("
                DATE_FORMAT(tanggal, '%Y-%m') AS periode,
                SUM(nominal) AS total
            ")
            ->from('penerimaan_zis')
            ->group_by("DATE_FORMAT(tanggal, '%Y-%m')")
            ->order_by('periode', 'ASC')
            ->get()
            ->result();
    }

    public function get_penyaluran_bulanan($bulan, $tahun) {
        $this->filter_tanggal($bulan, $tahun);

        return $this->db
            ->select("
                DATE_FORMAT(tanggal, '%Y-%m') AS periode,
                SUM(nominal) AS total
            ")
            ->from('penyaluran_zis')
            ->group_by("DATE_FORMAT(tanggal, '%Y-%m')")
            ->order_by('periode', 'ASC')
            ->get()
            ->result();
    }

    public function get_penerimaan_terbaru($bulan, $tahun, $limit = 5) {
        $this->filter_tanggal($bulan, $tahun);

        return $this->db
            ->from('penerimaan_zis')
            ->order_by('tanggal', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function get_penyaluran_terbaru($bulan, $tahun, $limit = 5) {
        $this->filter_tanggal($bulan, $tahun);

        return $this->db
            ->from('penyaluran_zis')
            ->order_by('tanggal', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function get_mustahik_terbaru($limit = 5) {
        return $this->db
            ->from('mustahik')
            ->order_by('tanggal_terdaftar', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function get_tahun_transaksi() {
        $tahun = [];

        $penerimaan = $this->db
            ->select('YEAR(tanggal) AS tahun')
            ->from('penerimaan_zis')
            ->where('tanggal IS NOT NULL', null, false)
            ->group_by('YEAR(tanggal)')
            ->order_by('tahun', 'DESC')
            ->get()
            ->result();

        foreach ($penerimaan as $row) {
            $tahun[] = (int) $row->tahun;
        }

        $penyaluran = $this->db
            ->select('YEAR(tanggal) AS tahun')
            ->from('penyaluran_zis')
            ->where('tanggal IS NOT NULL', null, false)
            ->group_by('YEAR(tanggal)')
            ->order_by('tahun', 'DESC')
            ->get()
            ->result();

        foreach ($penyaluran as $row) {
            $tahun[] = (int) $row->tahun;
        }

        $tahun[] = (int) date('Y');

        $tahun = array_unique($tahun);
        rsort($tahun);

        return $tahun;
    }
}