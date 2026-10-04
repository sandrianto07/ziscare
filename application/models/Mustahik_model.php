<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mustahik_model extends CI_Model
{
    private $table = 'mustahik';


    // ================================================================
    // GET ALL
    // ================================================================

    public function get_all()
    {
        return $this->db
            ->order_by(
                'id',
                'DESC'
            )
            ->get($this->table)
            ->result();
    }


    // ================================================================
    // GET BY ID
    // ================================================================

    public function get_by_id($id)
    {
        return $this->db
            ->where(
                'id',
                $id
            )
            ->get($this->table)
            ->row();
    }


    // ================================================================
    // INSERT
    // ================================================================

    public function insert($data)
    {
        return $this->db
            ->insert(
                $this->table,
                $data
            );
    }


    // ================================================================
    // UPDATE
    // ================================================================

    public function update($id, $data)
    {
        return $this->db
            ->where(
                'id',
                $id
            )
            ->update(
                $this->table,
                $data
            );
    }


    // ================================================================
    // DELETE
    // ================================================================

    public function delete($id)
    {
        return $this->db
            ->where(
                'id',
                $id
            )
            ->delete(
                $this->table
            );
    }


    // ================================================================
    // GENERATE KODE
    // ================================================================

    public function generate_kode()
    {
        $prefix = 'MST-' . date('Ym') . '-';


        $this->db
            ->select('kode_mustahik')
            ->like(
                'kode_mustahik',
                $prefix,
                'after'
            )
            ->order_by(
                'id',
                'DESC'
            )
            ->limit(1);


        $query =
            $this->db
                ->get($this->table);


        if (
            $query->num_rows() === 0
        ) {

            $number = 1;

        } else {

            $last =
                $query->row()->kode_mustahik;

            $number =
                (int) substr(
                    $last,
                    -4
                ) + 1;
        }


        return $prefix .
            str_pad(
                $number,
                4,
                '0',
                STR_PAD_LEFT
            );
    }

    public function nik_exists($nik, $exclude_id = null) {
        $this->db->where('nik', $nik);

        if ($exclude_id !== null) {
            $this->db->where('id !=', $exclude_id);
        }

        return $this->db->count_all_results('mustahik') > 0;
    }
}