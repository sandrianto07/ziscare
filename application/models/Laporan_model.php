<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    private $table_penerimaan = 'penerimaan_zis';
    private $table_penyaluran = 'penyaluran_zis';
    private $table_mustahik = 'mustahik';

    public function get_total_penerimaan($bulan = null, $tahun = null, $jenis_zis = null, $tanggal_mulai = null, $tanggal_selesai = null)
    {
        $this->db->select_sum('nominal');
        $this->db->where('status', 'tercatat');
        $this->db->where('deleted_at IS NULL', null, false);

        $this->_filter_transaksi(
            $bulan,
            $tahun,
            $jenis_zis,
            $tanggal_mulai,
            $tanggal_selesai
        );

        $result = $this->db
            ->get($this->table_penerimaan)
            ->row();

        return (float) ($result->nominal ?? 0);
    }

    public function get_total_penyaluran($bulan = null, $tahun = null, $jenis_zis = null, $tanggal_mulai = null, $tanggal_selesai = null)
    {
        $this->db->select_sum('nominal');
        $this->db->where('status', 'tersalurkan');
        $this->db->where('deleted_at IS NULL', null, false);

        $this->_filter_transaksi(
            $bulan,
            $tahun,
            $jenis_zis,
            $tanggal_mulai,
            $tanggal_selesai
        );

        $result = $this->db
            ->get($this->table_penyaluran)
            ->row();

        return (float) ($result->nominal ?? 0);
    }

    public function get_total_mustahik($filters = [], $status = null)
    {
        if (!empty($filters['kategori'])) {
            $this->db->where(
                'kategori_mustahik',
                $filters['kategori']
            );
        }

        if (!empty($filters['desa'])) {
            $this->db->like(
                'desa',
                $filters['desa']
            );
        }

        if (!empty($filters['kecamatan'])) {
            $this->db->like(
                'kecamatan',
                $filters['kecamatan']
            );
        }

        if ($status !== null) {
            $this->db->where(
                'status',
                $status
            );
        } elseif (!empty($filters['status'])) {
            $this->db->where(
                'status',
                $filters['status']
            );
        }

        if (!empty($filters['tanggal_mulai'])) {
            $this->db->where(
                'tanggal_terdaftar >=',
                $filters['tanggal_mulai']
            );
        }

        if (!empty($filters['tanggal_selesai'])) {
            $this->db->where(
                'tanggal_terdaftar <=',
                $filters['tanggal_selesai']
            );
        }

        return $this->db
            ->count_all_results($this->table_mustahik);
    }

    public function get_laporan_penerimaan($filters = [])
    {
        $this->db->select('*');

        $this->db->where('status', 'tercatat');
        $this->db->where('deleted_at IS NULL', null, false);

        $this->_filter_transaksi(
            $filters['bulan'] ?? null,
            $filters['tahun'] ?? null,
            $filters['jenis_zis'] ?? null,
            $filters['tanggal_mulai'] ?? null,
            $filters['tanggal_selesai'] ?? null
        );

        $this->db->order_by('tanggal', 'DESC');
        $this->db->order_by('id', 'DESC');

        return $this->db
            ->get($this->table_penerimaan)
            ->result();
    }

    public function get_laporan_penyaluran($filters = [])
    {
        $this->db->select('
            penyaluran_zis.*,
            mustahik.nama_lengkap AS nama_penerima,
            mustahik.nik,
            mustahik.kategori_mustahik
        ');

        $this->db->from($this->table_penyaluran);

        $this->db->join(
            $this->table_mustahik,
            'mustahik.id = penyaluran_zis.mustahik_id',
            'left'
        );

        $this->db->where(
            'penyaluran_zis.status',
            'tersalurkan'
        );

        $this->db->where(
            'penyaluran_zis.deleted_at IS NULL',
            null,
            false
        );

        $this->_filter_transaksi(
            $filters['bulan'] ?? null,
            $filters['tahun'] ?? null,
            $filters['jenis_zis'] ?? null,
            $filters['tanggal_mulai'] ?? null,
            $filters['tanggal_selesai'] ?? null,
            'penyaluran_zis'
        );

        $this->db->order_by(
            'penyaluran_zis.tanggal',
            'DESC'
        );

        $this->db->order_by(
            'penyaluran_zis.id',
            'DESC'
        );

        return $this->db
            ->get()
            ->result();
    }

    public function get_laporan_mustahik($filters = [])
    {
        if (!empty($filters['kategori'])) {
            $this->db->where(
                'kategori_mustahik',
                $filters['kategori']
            );
        }

        if (!empty($filters['status'])) {
            $this->db->where(
                'status',
                $filters['status']
            );
        }

        if (!empty($filters['desa'])) {
            $this->db->like(
                'desa',
                $filters['desa']
            );
        }

        if (!empty($filters['kecamatan'])) {
            $this->db->like(
                'kecamatan',
                $filters['kecamatan']
            );
        }

        if (!empty($filters['tanggal_mulai'])) {
            $this->db->where(
                'tanggal_terdaftar >=',
                $filters['tanggal_mulai']
            );
        }

        if (!empty($filters['tanggal_selesai'])) {
            $this->db->where(
                'tanggal_terdaftar <=',
                $filters['tanggal_selesai']
            );
        }

        $this->db->order_by(
            'nama_lengkap',
            'ASC'
        );

        return $this->db
            ->get($this->table_mustahik)
            ->result();
    }

    public function get_penerimaan_bulanan($tahun = null)
    {
        $tahun = $tahun ?: date('Y');

        $this->db->select(
            'MONTH(tanggal) AS bulan, SUM(nominal) AS total'
        );

        $this->db->where(
            'YEAR(tanggal)',
            (int) $tahun
        );

        $this->db->where(
            'status',
            'tercatat'
        );

        $this->db->where(
            'deleted_at IS NULL',
            null,
            false
        );

        $this->db->group_by(
            'MONTH(tanggal)'
        );

        $this->db->order_by(
            'MONTH(tanggal)',
            'ASC'
        );

        return $this->db
            ->get($this->table_penerimaan)
            ->result();
    }

    public function get_penyaluran_bulanan($tahun = null)
    {
        $tahun = $tahun ?: date('Y');

        $this->db->select(
            'MONTH(tanggal) AS bulan, SUM(nominal) AS total'
        );

        $this->db->where(
            'YEAR(tanggal)',
            (int) $tahun
        );

        $this->db->where(
            'status',
            'tersalurkan'
        );

        $this->db->where(
            'deleted_at IS NULL',
            null,
            false
        );

        $this->db->group_by(
            'MONTH(tanggal)'
        );

        $this->db->order_by(
            'MONTH(tanggal)',
            'ASC'
        );

        return $this->db
            ->get($this->table_penyaluran)
            ->result();
    }

    public function get_rekap_jenis_penerimaan($bulan = null, $tahun = null)
    {
        $this->db->select(
            'jenis_zis, SUM(nominal) AS total'
        );

        $this->db->where(
            'status',
            'tercatat'
        );

        $this->db->where(
            'deleted_at IS NULL',
            null,
            false
        );

        $this->_filter_transaksi(
            $bulan,
            $tahun
        );

        $this->db->group_by(
            'jenis_zis'
        );

        $this->db->order_by(
            'total',
            'DESC'
        );

        return $this->db
            ->get($this->table_penerimaan)
            ->result();
    }

    public function get_rekap_jenis_penyaluran($bulan = null, $tahun = null)
    {
        $this->db->select(
            'jenis_zis, SUM(nominal) AS total'
        );

        $this->db->where(
            'status',
            'tersalurkan'
        );

        $this->db->where(
            'deleted_at IS NULL',
            null,
            false
        );

        $this->_filter_transaksi(
            $bulan,
            $tahun
        );

        $this->db->group_by(
            'jenis_zis'
        );

        $this->db->order_by(
            'total',
            'DESC'
        );

        return $this->db
            ->get($this->table_penyaluran)
            ->result();
    }

    public function get_rekap_kategori_mustahik()
    {
        $this->db->select(
            'kategori_mustahik, COUNT(*) AS total'
        );

        $this->db->group_by(
            'kategori_mustahik'
        );

        $this->db->order_by(
            'total',
            'DESC'
        );

        return $this->db
            ->get($this->table_mustahik)
            ->result();
    }

    public function get_desa_mustahik()
    {
        $this->db->select(
            'desa, COUNT(*) AS total'
        );

        $this->db->where(
            'desa IS NOT NULL',
            null,
            false
        );

        $this->db->where(
            'desa !=',
            ''
        );

        $this->db->group_by(
            'desa'
        );

        $this->db->order_by(
            'desa',
            'ASC'
        );

        return $this->db
            ->get($this->table_mustahik)
            ->result();
    }

    private function _filter_transaksi(
        $bulan = null,
        $tahun = null,
        $jenis_zis = null,
        $tanggal_mulai = null,
        $tanggal_selesai = null,
        $table = null
    ) {
        $prefix = $table ? $table . '.' : '';

        if (!empty($bulan)) {
            $this->db->where(
                'MONTH(' . $prefix . 'tanggal)',
                (int) $bulan
            );
        }

        if (!empty($tahun)) {
            $this->db->where(
                'YEAR(' . $prefix . 'tanggal)',
                (int) $tahun
            );
        }

        if (!empty($jenis_zis)) {
            $jenis_zis = strtolower(
                trim($jenis_zis)
            );

            if ($jenis_zis === 'infaq') {
                $jenis_zis = 'infak';
            }

            if ($jenis_zis === 'infak') {
                $this->db->where(
                    "LOWER({$prefix}jenis_zis) IN ('infak', 'infaq')",
                    null,
                    false
                );
            } else {
                $this->db->where(
                    "LOWER({$prefix}jenis_zis) = " .
                    $this->db->escape($jenis_zis),
                    null,
                    false
                );
            }
        }

        if (!empty($tanggal_mulai)) {
            $this->db->where(
                $prefix . 'tanggal >=',
                $tanggal_mulai
            );
        }

        if (!empty($tanggal_selesai)) {
            $this->db->where(
                $prefix . 'tanggal <=',
                $tanggal_selesai
            );
        }
    }
}