<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerimaan_model extends CI_Model
{
    private $table = 'penerimaan_zis';

    public function get_all()
    {
        return $this->db
            ->select('penerimaan_zis.*, users.nama_lengkap AS nama_admin')
            ->from($this->table)
            ->join('users', 'users.id = penerimaan_zis.created_by', 'left')
            ->order_by('penerimaan_zis.tanggal', 'DESC')
            ->order_by('penerimaan_zis.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->where('id', $id)
            ->get($this->table)
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

    public function delete($id) {
        if (empty($id)) {
            return false;
        }

        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

    public function generate_kode()
    {
        $prefix = 'ZIS-' . date('Ym') . '-';

        $last = $this->db
            ->like('kode_transaksi', $prefix, 'after')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get($this->table)
            ->row();

        if ($last) {
            $nomor = (int) substr($last->kode_transaksi, -4);
            $nomor++;
        } else {
            $nomor = 1;
        }

        return $prefix . str_pad($nomor, 4, '0', STR_PAD_LEFT);
    }
}