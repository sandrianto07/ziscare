<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mustahik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $this->load->model(['Mustahik_model', 'Dashboard_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $user = $this->_get_user();

        if (!$user) return;

        $data = [
            'title' => 'Data Mustahik | ZIS Care',
            'page_title' => 'Data Mustahik',
            'user' => $user,
            'data' => $this->Mustahik_model->get_all()
        ];

        $this->load->view('mustahik/index', $data);
    }

    public function tambah()
    {
        $user = $this->_get_user();

        if (!$user) return;

        $this->load->view('mustahik/form', [
            'title' => 'Tambah Mustahik | ZIS Care',
            'page_title' => 'Tambah Mustahik',
            'user' => $user,
            'mode' => 'tambah',
            'data' => null
        ]);
    }

    public function simpan()
    {
        $user = $this->_get_user();

        if (!$user) return;

        $this->_set_validation_rules();

        if (!$this->form_validation->run()) {
            return $this->_show_form('tambah', null, $user, validation_errors('<div>', '</div>'));
        }

        $nik = trim($this->input->post('nik', true));

        if ($this->Mustahik_model->nik_exists($nik)) {
            return $this->_show_form('tambah', null, $user, 'NIK <strong>' . html_escape($nik) . '</strong> sudah terdaftar.');
        }

        $data = [
            'kode_mustahik' => $this->Mustahik_model->generate_kode(),
            'nik' => $nik,
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
            'no_hp' => $this->input->post('no_hp', true),
            'alamat' => $this->input->post('alamat', true),
            'desa' => $this->input->post('desa', true),
            'kecamatan' => $this->input->post('kecamatan', true),
            'kategori_mustahik' => $this->input->post('kategori_mustahik', true),
            'status' => $this->input->post('status', true),
            'keterangan' => $this->input->post('keterangan', true),
            'tanggal_terdaftar' => $this->input->post('tanggal_terdaftar', true),
            'created_by' => $this->session->userdata('user_id')
        ];

        if (!$this->Mustahik_model->insert($data)) {
            return $this->_show_form('tambah', null, $user, 'Data mustahik gagal disimpan.');
        }

        $this->session->set_flashdata('success', 'Data mustahik berhasil ditambahkan.');
        redirect('mustahik');
    }

    public function edit($id = null)
    {
        $user = $this->_get_user();

        if (!$user) return;

        if (!$id || !is_numeric($id)) show_404();

        $mustahik = $this->Mustahik_model->get_by_id($id);

        if (!$mustahik) {
            $this->session->set_flashdata('error', 'Data mustahik tidak ditemukan.');
            redirect('mustahik');
            return;
        }

        $this->load->view('mustahik/form', [
            'title' => 'Edit Mustahik | ZIS Care',
            'page_title' => 'Edit Mustahik',
            'user' => $user,
            'mode' => 'edit',
            'data' => $mustahik
        ]);
    }

    public function update($id = null)
    {
        $user = $this->_get_user();

        if (!$user) return;

        if (!$id || !is_numeric($id)) show_404();

        $mustahik = $this->Mustahik_model->get_by_id($id);

        if (!$mustahik) {
            $this->session->set_flashdata('error', 'Data mustahik tidak ditemukan.');
            redirect('mustahik');
            return;
        }

        $this->_set_validation_rules();

        if (!$this->form_validation->run()) {
            return $this->_show_form('edit', $mustahik, $user, validation_errors('<div>', '</div>'));
        }

        $nik = trim($this->input->post('nik', true));

        if ($this->Mustahik_model->nik_exists($nik, $id)) {
            return $this->_show_form('edit', $mustahik, $user, 'NIK <strong>' . html_escape($nik) . '</strong> sudah terdaftar pada data mustahik lain.');
        }

        $data = [
            'nik' => $nik,
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
            'no_hp' => $this->input->post('no_hp', true),
            'alamat' => $this->input->post('alamat', true),
            'desa' => $this->input->post('desa', true),
            'kecamatan' => $this->input->post('kecamatan', true),
            'kategori_mustahik' => $this->input->post('kategori_mustahik', true),
            'status' => $this->input->post('status', true),
            'keterangan' => $this->input->post('keterangan', true),
            'tanggal_terdaftar' => $this->input->post('tanggal_terdaftar', true)
        ];

        if (!$this->Mustahik_model->update($id, $data)) {
            return $this->_show_form('edit', $mustahik, $user, 'Data mustahik gagal diperbarui.');
        }

        $this->session->set_flashdata('success', 'Data mustahik berhasil diperbarui.');
        redirect('mustahik');
    }

    public function hapus($id = null)
    {
        $user = $this->_get_user();

        if (!$user) return;

        if (!$id || !is_numeric($id)) show_404();

        if (!$this->Mustahik_model->get_by_id($id)) {
            $this->session->set_flashdata('error', 'Data mustahik tidak ditemukan.');
            redirect('mustahik');
            return;
        }

        if (!$this->Mustahik_model->delete($id)) {
            $this->session->set_flashdata('error', 'Data mustahik gagal dihapus.');
            redirect('mustahik');
            return;
        }

        $this->session->set_flashdata('success', 'Data mustahik berhasil dihapus.');
        redirect('mustahik');
    }

    private function _set_validation_rules()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|numeric|exact_length[16]', [
            'required' => 'NIK wajib diisi.',
            'numeric' => 'NIK hanya boleh berupa angka.',
            'exact_length' => 'NIK harus terdiri dari 16 digit.'
        ]);

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim|max_length[150]', [
            'required' => 'Nama lengkap wajib diisi.',
            'max_length' => 'Nama lengkap maksimal 150 karakter.'
        ]);

        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[laki-laki,perempuan]', [
            'required' => 'Jenis kelamin wajib dipilih.',
            'in_list' => 'Jenis kelamin tidak valid.'
        ]);

        $this->form_validation->set_rules('no_hp', 'No. HP', 'trim|numeric|max_length[20]', [
            'numeric' => 'No. HP hanya boleh berupa angka.',
            'max_length' => 'No. HP maksimal 20 digit.'
        ]);

        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', [
            'required' => 'Alamat wajib diisi.'
        ]);

        $this->form_validation->set_rules('desa', 'Desa', 'trim|max_length[100]');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'trim|max_length[100]');

        $this->form_validation->set_rules('kategori_mustahik', 'Kategori Mustahik', 'required|in_list[fakir,miskin,amil,muallaf,riqab,gharim,fisabilillah,ibnu_sabil]', [
            'required' => 'Kategori mustahik wajib dipilih.',
            'in_list' => 'Kategori mustahik tidak valid.'
        ]);

        $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,tidak_aktif]', [
            'required' => 'Status wajib dipilih.',
            'in_list' => 'Status tidak valid.'
        ]);

        $this->form_validation->set_rules('tanggal_terdaftar', 'Tanggal Terdaftar', 'required', [
            'required' => 'Tanggal terdaftar wajib diisi.'
        ]);

        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[1000]', [
            'max_length' => 'Keterangan maksimal 1000 karakter.'
        ]);
    }

    private function _show_form($mode, $data, $user, $form_error)
    {
        $this->load->view('mustahik/form', [
            'title' => ucfirst($mode) . ' Mustahik | ZIS Care',
            'page_title' => ucfirst($mode) . ' Mustahik',
            'user' => $user,
            'mode' => $mode,
            'data' => $data,
            'form_error' => $form_error
        ]);
    }

    private function _get_user()
    {
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            $this->session->sess_destroy();
            redirect('login');
            return false;
        }

        $user = $this->Dashboard_model->get_user($user_id);

        if (!$user) {
            $this->session->sess_destroy();
            redirect('login');
            return false;
        }

        return $user;
    }
}