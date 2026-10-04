<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyaluran_model extends CI_Model
{
    private $table = 'penyaluran_zis';

    public function get_all()
    {
        return $this->db
            ->select('
                penyaluran_zis.*,
                users.nama_lengkap AS nama_admin,
                mustahik.nama_lengkap AS nama_penerima,
                mustahik.nik,
                mustahik.kategori_mustahik
            ')
            ->from($this->table)
            ->join('users', 'users.id = penyaluran_zis.created_by', 'left')
            ->join('mustahik', 'mustahik.id = penyaluran_zis.mustahik_id', 'left')
            ->order_by('penyaluran_zis.tanggal', 'DESC')
            ->order_by('penyaluran_zis.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->select('
                penyaluran_zis.*,
                users.nama_lengkap AS nama_admin,
                mustahik.nama_lengkap AS nama_penerima,
                mustahik.nik,
                mustahik.kategori_mustahik
            ')
            ->from($this->table)
            ->join('users', 'users.id = penyaluran_zis.created_by', 'left')
            ->join('mustahik', 'mustahik.id = penyaluran_zis.mustahik_id', 'left')
            ->where('penyaluran_zis.id', $id)
            ->get()
            ->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        if (empty($id)) {
            return false;
        }

        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

    public function generate_kode()
    {
        $prefix = 'PEN-' . date('Ym') . '-';

        $last = $this->db
            ->select('kode_penyaluran')
            ->where('kode_penyaluran LIKE', $prefix . '%')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get($this->table)
            ->row();

        $number = $last
            ? ((int) substr($last->kode_penyaluran, -4) + 1)
            : 1;

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function get_saldo()
    {
        $penerimaan = $this->db
            ->select_sum('nominal')
            ->where('status', 'tercatat')
            ->where('deleted_at IS NULL', null, false)
            ->get('penerimaan_zis')
            ->row();

        $penyaluran = $this->db
            ->select_sum('nominal')
            ->where('status', 'tersalurkan')
            ->where('deleted_at IS NULL', null, false)
            ->get($this->table)
            ->row();

        $total_penerimaan = (float) ($penerimaan->nominal ?? 0);
        $total_penyaluran = (float) ($penyaluran->nominal ?? 0);

        return max(0, $total_penerimaan - $total_penyaluran);
    }

    public function get_saldo_by_jenis($jenis_zis)
    {
        $jenis_zis = strtolower(trim($jenis_zis));

        if ($jenis_zis === 'infaq') {
            $jenis_zis = 'infak';
        }

        if (!in_array($jenis_zis, ['zakat', 'infak', 'sedekah'], true)) {
            return 0;
        }

        if ($jenis_zis === 'infak') {
            $kondisi_jenis = "LOWER(jenis_zis) IN ('infak', 'infaq')";
        } else {
            $kondisi_jenis = 'LOWER(jenis_zis) = ' . $this->db->escape($jenis_zis);
        }

        $penerimaan = $this->db
            ->select_sum('nominal')
            ->where('status', 'tercatat')
            ->where('deleted_at IS NULL', null, false)
            ->where($kondisi_jenis, null, false)
            ->get('penerimaan_zis')
            ->row();

        $penyaluran = $this->db
            ->select_sum('nominal')
            ->where('status', 'tersalurkan')
            ->where('deleted_at IS NULL', null, false)
            ->where($kondisi_jenis, null, false)
            ->get($this->table)
            ->row();

        $total_penerimaan = (float) ($penerimaan->nominal ?? 0);
        $total_penyaluran = (float) ($penyaluran->nominal ?? 0);

        return max(0, $total_penerimaan - $total_penyaluran);
    }

    public function get_saldo_by_jenis_for_update($jenis_zis, $id)
    {
        $jenis_zis = strtolower(trim($jenis_zis));

        if ($jenis_zis === 'infaq') {
            $jenis_zis = 'infak';
        }

        $saldo = $this->get_saldo_by_jenis($jenis_zis);
        $data = $this->get_by_id($id);

        if (!$data) {
            return $saldo;
        }

        $jenis_lama = strtolower(trim($data->jenis_zis));

        if ($jenis_lama === 'infaq') {
            $jenis_lama = 'infak';
        }

        if ($jenis_lama === $jenis_zis) {
            $saldo += (float) $data->nominal;
        }

        return max(0, $saldo);
    }

    public function get_saldo_semua_jenis()
    {
        return [
            'zakat' => $this->get_saldo_by_jenis('zakat'),
            'infak' => $this->get_saldo_by_jenis('infak'),
            'sedekah' => $this->get_saldo_by_jenis('sedekah')
        ];
    }

    public function get_nama_jenis($jenis_zis)
    {
        $jenis_zis = strtolower(trim($jenis_zis));

        $nama = [
            'zakat' => 'Zakat',
            'infak' => 'Infak',
            'infaq' => 'Infak',
            'sedekah' => 'Sedekah'
        ];

        return $nama[$jenis_zis] ?? ucfirst($jenis_zis);
    }
}