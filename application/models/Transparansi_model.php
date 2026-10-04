<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transparansi_model extends CI_Model
{
    private function filter_tanggal($query, $dari = null, $sampai = null, $tanggal = 'tanggal')
    {
        if ($dari) {
            $query->where($tanggal . ' >=', $dari);
        }

        if ($sampai) {
            $query->where($tanggal . ' <=', $sampai);
        }

        return $query;
    }

    public function get_ringkasan($dari = null, $sampai = null)
    {
        $query = $this->db
            ->select_sum('nominal')
            ->where('status', 'tercatat')
            ->where('deleted_at IS NULL', null, false);

        $this->filter_tanggal($query, $dari, $sampai);

        $penerimaan = (float) ($query->get('penerimaan_zis')->row()->nominal ?? 0);

        $query = $this->db
            ->select_sum('nominal')
            ->where('status', 'tersalurkan')
            ->where('deleted_at IS NULL', null, false);

        $this->filter_tanggal($query, $dari, $sampai);

        $penyaluran = (float) ($query->get('penyaluran_zis')->row()->nominal ?? 0);

        $query = $this->db
            ->where('status', 'tercatat')
            ->where('deleted_at IS NULL', null, false);

        $this->filter_tanggal($query, $dari, $sampai);

        $jumlah_penerimaan = $query->count_all_results('penerimaan_zis');

        $query = $this->db
            ->where('status', 'tersalurkan')
            ->where('deleted_at IS NULL', null, false);

        $this->filter_tanggal($query, $dari, $sampai);

        $jumlah_penyaluran = $query->count_all_results('penyaluran_zis');

        return [
            'total_penerimaan' => $penerimaan,
            'total_penyaluran' => $penyaluran,
            'saldo' => $penerimaan - $penyaluran,
            'jumlah_penerimaan' => $jumlah_penerimaan,
            'jumlah_penyaluran' => $jumlah_penyaluran
        ];
    }

    public function get_rekap_penerimaan($dari = null, $sampai = null)
    {
        $query = $this->db
            ->select('jenis_zis, COUNT(id) AS jumlah, SUM(nominal) AS total', false)
            ->where('status', 'tercatat')
            ->where('deleted_at IS NULL', null, false);

        $this->filter_tanggal($query, $dari, $sampai);

        $rows = $query
            ->group_by('jenis_zis')
            ->order_by('total', 'DESC')
            ->get('penerimaan_zis')
            ->result();

        $result = [
            'zakat' => [
                'jumlah' => 0,
                'total' => 0,
                'persentase' => 0
            ],
            'infaq' => [
                'jumlah' => 0,
                'total' => 0,
                'persentase' => 0
            ],
            'sedekah' => [
                'jumlah' => 0,
                'total' => 0,
                'persentase' => 0
            ]
        ];

        $total = 0;

        foreach ($rows as $row) {
            $jenis = strtolower(trim($row->jenis_zis));

            if ($jenis === 'infak') {
                $jenis = 'infaq';
            }

            if (!isset($result[$jenis])) {
                continue;
            }

            $result[$jenis]['jumlah'] = (int) $row->jumlah;
            $result[$jenis]['total'] = (float) $row->total;

            $total += (float) $row->total;
        }

        foreach ($result as $jenis => $data) {
            $result[$jenis]['persentase'] = $total > 0
                ? round(($data['total'] / $total) * 100, 1)
                : 0;
        }

        return $result;
    }

    public function get_rekap_penyaluran($dari = null, $sampai = null)
    {
        $query = $this->db
            ->select('kategori_penerima, COUNT(id) AS jumlah, SUM(nominal) AS total', false)
            ->where('status', 'tersalurkan')
            ->where('deleted_at IS NULL', null, false);

        $this->filter_tanggal($query, $dari, $sampai);

        $rows = $query
            ->group_by('kategori_penerima')
            ->order_by('total', 'DESC')
            ->get('penyaluran_zis')
            ->result();

        $total = 0;

        foreach ($rows as $row) {
            $total += (float) $row->total;
        }

        foreach ($rows as $row) {
            $row->persentase = $total > 0
                ? round(((float) $row->total / $total) * 100, 1)
                : 0;
        }

        return $rows;
    }

    public function get_timeline($dari = null, $sampai = null, $limit = 20)
    {
        $penerimaan = $this->db
            ->select("id, tanggal, 'penerimaan' AS tipe, jenis_zis, nominal, metode_pembayaran AS metode, NULL AS kategori", false)
            ->where('status', 'tercatat')
            ->where('deleted_at IS NULL', null, false);

        $this->filter_tanggal($penerimaan, $dari, $sampai);

        $penerimaan = $penerimaan
            ->order_by('tanggal', 'DESC')
            ->order_by('id', 'DESC')
            ->limit($limit)
            ->get('penerimaan_zis')
            ->result();

        $penyaluran = $this->db
            ->select("id, tanggal, 'penyaluran' AS tipe, jenis_zis, nominal, metode_penyaluran AS metode, kategori_penerima AS kategori", false)
            ->where('status', 'tersalurkan')
            ->where('deleted_at IS NULL', null, false);

        $this->filter_tanggal($penyaluran, $dari, $sampai);

        $penyaluran = $penyaluran
            ->order_by('tanggal', 'DESC')
            ->order_by('id', 'DESC')
            ->limit($limit)
            ->get('penyaluran_zis')
            ->result();

        $timeline = array_merge($penerimaan, $penyaluran);

        usort($timeline, static function ($a, $b) {
            $tanggal = strcmp($b->tanggal, $a->tanggal);

            if ($tanggal !== 0) {
                return $tanggal;
            }

            return $b->id <=> $a->id;
        });

        return array_slice($timeline, 0, $limit);
    }

    public function get_transaksi_publik($dari = null, $sampai = null, $limit = 30)
    {
        $penerimaan = $this->db
            ->select("id, tanggal, 'Penerimaan' AS aktivitas, jenis_zis, nominal, metode_pembayaran AS metode, NULL AS kategori", false)
            ->where('status', 'tercatat')
            ->where('deleted_at IS NULL', null, false);

        $this->filter_tanggal($penerimaan, $dari, $sampai);

        $penerimaan = $penerimaan
            ->order_by('tanggal', 'DESC')
            ->order_by('id', 'DESC')
            ->limit($limit)
            ->get('penerimaan_zis')
            ->result();

        $penyaluran = $this->db
            ->select("id, tanggal, 'Penyaluran' AS aktivitas, jenis_zis, nominal, metode_penyaluran AS metode, kategori_penerima AS kategori", false)
            ->where('status', 'tersalurkan')
            ->where('deleted_at IS NULL', null, false);

        $this->filter_tanggal($penyaluran, $dari, $sampai);

        $penyaluran = $penyaluran
            ->order_by('tanggal', 'DESC')
            ->order_by('id', 'DESC')
            ->limit($limit)
            ->get('penyaluran_zis')
            ->result();

        $transaksi = array_merge($penerimaan, $penyaluran);

        usort($transaksi, static function ($a, $b) {
            $tanggal = strcmp($b->tanggal, $a->tanggal);

            if ($tanggal !== 0) {
                return $tanggal;
            }

            return $b->id <=> $a->id;
        });

        return array_slice($transaksi, 0, $limit);
    }

    public function get_periode()
    {
        $penerimaan = $this->db
            ->select("DATE_FORMAT(tanggal, '%Y-%m') AS periode", false)
            ->where('status', 'tercatat')
            ->where('deleted_at IS NULL', null, false)
            ->group_by("DATE_FORMAT(tanggal, '%Y-%m')", false)
            ->get('penerimaan_zis')
            ->result();

        $penyaluran = $this->db
            ->select("DATE_FORMAT(tanggal, '%Y-%m') AS periode", false)
            ->where('status', 'tersalurkan')
            ->where('deleted_at IS NULL', null, false)
            ->group_by("DATE_FORMAT(tanggal, '%Y-%m')", false)
            ->get('penyaluran_zis')
            ->result();

        $periode = array_merge(
            array_column($penerimaan, 'periode'),
            array_column($penyaluran, 'periode')
        );

        $periode = array_values(array_unique($periode));
        rsort($periode);

        return $periode;
    }
}