<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerimaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // ============================================================
        // AUTHENTICATION
        // ============================================================
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        // ============================================================
        // LOAD DEPENDENCIES
        // ============================================================
        $this->load->model('Penerimaan_model');
        $this->load->model('Dashboard_model');

        $this->load->library([
            'session',
            'form_validation'
        ]);

        $this->load->helper([
            'url',
            'form'
        ]);
    }


    // ================================================================
    // INDEX
    // ================================================================

    public function index()
    {
        $user = $this->_get_user();

        if (!$user) {
            return;
        }

        $data = [
            'title'      => 'Penerimaan ZIS | ZIS Care',
            'page_title' => 'Penerimaan ZIS',
            'user'       => $user,
            'data'       => $this->Penerimaan_model->get_all()
        ];

        $this->load->view(
            'penerimaan/index',
            $data
        );
    }


    // ================================================================
    // TAMBAH
    // ================================================================

    public function tambah()
    {
        $user = $this->_get_user();

        if (!$user) {
            return;
        }

        $data = [
            'title'      => 'Tambah Penerimaan | ZIS Care',
            'page_title' => 'Tambah Penerimaan',
            'user'       => $user,
            'mode'       => 'tambah',
            'data'       => null
        ];

        $this->_render_form($data);
    }


    // ================================================================
    // SIMPAN
    // ================================================================

    public function simpan()
    {
        $user = $this->_get_user();

        if (!$user) {
            return;
        }

        // ------------------------------------------------------------
        // VALIDATION
        // ------------------------------------------------------------
        $this->_set_validation_rules();

        if ($this->form_validation->run() === false) {

            $data = [
                'title'      => 'Tambah Penerimaan | ZIS Care',
                'page_title' => 'Tambah Penerimaan',
                'user'       => $user,
                'mode'       => 'tambah',
                'data'       => null
            ];

            $this->_render_form(
                $data,
                validation_errors('<div>', '</div>')
            );

            return;
        }

        $this->form_validation->set_rules(
            'no_hp_donatur',
            'Nomor Telepon',
            'trim|numeric|max_length[20]',
            [
                'numeric' => 'Nomor telepon hanya boleh berupa angka.',
                'max_length' => 'Nomor telepon maksimal 20 digit.'
            ]
        );

        $this->form_validation->set_rules(
            'alamat_donatur',
            'Alamat',
            'trim|max_length[255]',
            [
                'max_length' => 'Alamat maksimal 255 karakter.'
            ]
        );


        // ------------------------------------------------------------
        // NOMINAL
        // ------------------------------------------------------------
        $nominal = $this->_clean_nominal(
            $this->input->post('nominal')
        );

        if ($nominal <= 0) {

            $data = [
                'title'      => 'Tambah Penerimaan | ZIS Care',
                'page_title' => 'Tambah Penerimaan',
                'user'       => $user,
                'mode'       => 'tambah',
                'data'       => null
            ];

            $this->_render_form(
                $data,
                '<div>Nominal harus lebih dari 0.</div>'
            );

            return;
        }


        // ------------------------------------------------------------
        // UPLOAD BUKTI
        // ------------------------------------------------------------
        $bukti = null;

        if (
            isset($_FILES['bukti']) &&
            !empty($_FILES['bukti']['name'])
        ) {

            $bukti = $this->_upload_bukti();

            if ($bukti === false) {

                $data = [
                    'title'      => 'Tambah Penerimaan | ZIS Care',
                    'page_title' => 'Tambah Penerimaan',
                    'user'       => $user,
                    'mode'       => 'tambah',
                    'data'       => null
                ];

                $this->_render_form(
                    $data,
                    $this->session->flashdata('error')
                );

                return;
            }
        }


        // ------------------------------------------------------------
        // DATA
        // ------------------------------------------------------------
        $insert_data = [
            'kode_transaksi' => $this->Penerimaan_model->generate_kode(),
            'tanggal' => $this->input->post('tanggal', true),
            'jenis_zis' => $this->input->post('jenis_zis', true),
            'sumber_dana' => $this->input->post('sumber_dana', true),
            'alamat_donatur' => $this->input->post('alamat_donatur', true),
            'no_hp_donatur' => $this->input->post('no_hp_donatur', true),
            'nominal' => $nominal,
            'metode_pembayaran' => $this->input->post('metode_pembayaran', true),
            'keterangan' => $this->input->post('keterangan', true),
            'created_by' => $user['id']
        ];


        // ------------------------------------------------------------
        // INSERT
        // ------------------------------------------------------------
        $insert = $this->Penerimaan_model->insert($insert_data);

        if (!$insert) {

            // Hapus file jika database gagal menyimpan
            if ($bukti) {
                $file = FCPATH . 'uploads/bukti_zis/' . $bukti;

                if (file_exists($file)) {
                    @unlink($file);
                }
            }

            $data = [
                'title'      => 'Tambah Penerimaan | ZIS Care',
                'page_title' => 'Tambah Penerimaan',
                'user'       => $user,
                'mode'       => 'tambah',
                'data'       => null
            ];

            $this->_render_form(
                $data,
                '<div>Data gagal disimpan. Silakan coba kembali.</div>'
            );

            return;
        }


        // ------------------------------------------------------------
        // SUCCESS
        // ------------------------------------------------------------
        $this->session->set_flashdata(
            'success',
            'Data penerimaan ZIS berhasil ditambahkan.'
        );

        redirect('penerimaan');
    }


    // ================================================================
    // EDIT
    // ================================================================

    public function edit($id = null)
    {
        $user = $this->_get_user();

        if (!$user) {
            return;
        }

        if (!$id || !is_numeric($id)) {
            show_404();
            return;
        }

        $data_penerimaan =
            $this->Penerimaan_model->get_by_id($id);

        if (!$data_penerimaan) {

            $this->session->set_flashdata(
                'error',
                'Data penerimaan tidak ditemukan.'
            );

            redirect('penerimaan');
            return;
        }


        $data = [
            'title'      => 'Edit Penerimaan | ZIS Care',
            'page_title' => 'Edit Penerimaan',
            'user'       => $user,
            'mode'       => 'edit',
            'data'       => $data_penerimaan
        ];

        $this->_render_form($data);
    }


    // ================================================================
    // UPDATE
    // ================================================================

    public function update($id = null)
    {
        $user = $this->_get_user();

        if (!$user) {
            return;
        }

        if (!$id || !is_numeric($id)) {
            show_404();
            return;
        }

        $data_penerimaan =
            $this->Penerimaan_model->get_by_id($id);

        if (!$data_penerimaan) {
            show_404();
            return;
        }


        // ------------------------------------------------------------
        // VALIDATION
        // ------------------------------------------------------------
        $this->_set_validation_rules();

        if ($this->form_validation->run() === false) {

            $data = [
                'title'      => 'Edit Penerimaan | ZIS Care',
                'page_title' => 'Edit Penerimaan',
                'user'       => $user,
                'mode'       => 'edit',
                'data'       => $data_penerimaan
            ];

            $this->_render_form(
                $data,
                validation_errors('<div>', '</div>')
            );

            return;
        }

        $this->form_validation->set_rules(
            'no_hp_donatur',
            'Nomor Telepon',
            'trim|numeric|max_length[20]',
            [
                'numeric' => 'Nomor telepon hanya boleh berupa angka.',
                'max_length' => 'Nomor telepon maksimal 20 digit.'
            ]
        );

        $this->form_validation->set_rules(
            'alamat_donatur',
            'Alamat',
            'trim|max_length[255]',
            [
                'max_length' => 'Alamat maksimal 255 karakter.'
            ]
        );


        // ------------------------------------------------------------
        // NOMINAL
        // ------------------------------------------------------------
        $nominal = $this->_clean_nominal(
            $this->input->post('nominal')
        );

        if ($nominal <= 0) {

            $data = [
                'title'      => 'Edit Penerimaan | ZIS Care',
                'page_title' => 'Edit Penerimaan',
                'user'       => $user,
                'mode'       => 'edit',
                'data'       => $data_penerimaan
            ];

            $this->_render_form(
                $data,
                '<div>Nominal harus lebih dari 0.</div>'
            );

            return;
        }


        // ------------------------------------------------------------
        // DATA UPDATE
        // ------------------------------------------------------------
        $update_data = [
            'tanggal'           => $this->input->post('tanggal', true),
            'jenis_zis'         => $this->input->post('jenis_zis', true),
            'sumber_dana'       => $this->input->post('sumber_dana', true),
            'alamat_donatur'    => $this->input->post('alamat_donatur', true),
            'no_hp_donatur'     => $this->input->post('no_hp_donatur', true),
            'nominal'           => $nominal,
            'metode_pembayaran' => $this->input->post('metode_pembayaran', true),
            'keterangan'        => $this->input->post('keterangan', true)
        ];


        // ------------------------------------------------------------
        // UPLOAD BUKTI BARU
        // ------------------------------------------------------------
        $new_bukti = null;

        if (
            isset($_FILES['bukti']) &&
            !empty($_FILES['bukti']['name'])
        ) {

            $new_bukti = $this->_upload_bukti();

            if ($new_bukti === false) {

                $data = [
                    'title'      => 'Edit Penerimaan | ZIS Care',
                    'page_title' => 'Edit Penerimaan',
                    'user'       => $user,
                    'mode'       => 'edit',
                    'data'       => $data_penerimaan
                ];

                $this->_render_form(
                    $data,
                    $this->session->flashdata('error')
                );

                return;
            }

            $update_data['bukti'] = $new_bukti;
        }


        // ------------------------------------------------------------
        // UPDATE DATABASE
        // ------------------------------------------------------------
        $update = $this->Penerimaan_model->update(
            $id,
            $update_data
        );

        if (!$update) {

            // Jika database gagal, hapus file baru
            if ($new_bukti) {

                $new_file =
                    FCPATH .
                    'uploads/bukti_zis/' .
                    $new_bukti;

                if (file_exists($new_file)) {
                    @unlink($new_file);
                }
            }

            $data = [
                'title'      => 'Edit Penerimaan | ZIS Care',
                'page_title' => 'Edit Penerimaan',
                'user'       => $user,
                'mode'       => 'edit',
                'data'       => $data_penerimaan
            ];

            $this->_render_form(
                $data,
                '<div>Data gagal diperbarui. Silakan coba kembali.</div>'
            );

            return;
        }


        // ------------------------------------------------------------
        // HAPUS FILE LAMA
        // ------------------------------------------------------------
        if (
            $new_bukti &&
            !empty($data_penerimaan->bukti)
        ) {

            $old_file =
                FCPATH .
                'uploads/bukti_zis/' .
                $data_penerimaan->bukti;

            if (file_exists($old_file)) {
                @unlink($old_file);
            }
        }


        // ------------------------------------------------------------
        // SUCCESS
        // ------------------------------------------------------------
        $this->session->set_flashdata(
            'success',
            'Data penerimaan ZIS berhasil diperbarui.'
        );

        redirect('penerimaan');
    }


    // ================================================================
    // HAPUS
    // ================================================================

    public function hapus($id = null)
    {
        $user = $this->_get_user();

        if (!$user) {
            return;
        }

        if (!$id || !is_numeric($id)) {
            show_404();
            return;
        }

        $data =
            $this->Penerimaan_model->get_by_id($id);

        if (!$data) {

            $this->session->set_flashdata(
                'error',
                'Data penerimaan tidak ditemukan.'
            );

            redirect('penerimaan');
            return;
        }


        // ------------------------------------------------------------
        // DELETE DATABASE
        // ------------------------------------------------------------
        $delete =
            $this->Penerimaan_model->delete($id);

        if (!$delete) {

            $this->session->set_flashdata(
                'error',
                'Data penerimaan gagal dihapus.'
            );

            redirect('penerimaan');
            return;
        }


        // ------------------------------------------------------------
        // DELETE FILE
        // ------------------------------------------------------------
        if (!empty($data->bukti)) {

            $file =
                FCPATH .
                'uploads/bukti_zis/' .
                $data->bukti;

            if (file_exists($file)) {
                @unlink($file);
            }
        }


        // ------------------------------------------------------------
        // SUCCESS
        // ------------------------------------------------------------
        $this->session->set_flashdata(
            'success',
            'Data penerimaan ZIS berhasil dihapus.'
        );

        redirect('penerimaan');
    }


    // ================================================================
    // PRIVATE: GET USER
    // ================================================================

    private function _get_user()
    {
        $user_id =
            $this->session->userdata('user_id');

        if (!$user_id) {

            $this->session->sess_destroy();

            redirect('login');
            return false;
        }

        $user =
            $this->Dashboard_model->get_user($user_id);

        if (!$user) {

            $this->session->sess_destroy();

            redirect('login');
            return false;
        }

        return $user;
    }


    // ================================================================
    // PRIVATE: VALIDATION RULES
    // ================================================================

    private function _set_validation_rules()
    {
        $this->form_validation->set_rules(
            'tanggal',
            'Tanggal',
            'required|callback__valid_date',
            [
                'required' =>
                    'Tanggal wajib diisi.'
            ]
        );

        $this->form_validation->set_rules(
            'jenis_zis',
            'Jenis ZIS',
            'required|in_list[zakat,infak,sedekah]',
            [
                'required' =>
                    'Jenis ZIS wajib dipilih.',
                'in_list' =>
                    'Jenis ZIS tidak valid.'
            ]
        );

        $this->form_validation->set_rules(
            'sumber_dana',
            'Sumber Dana',
            'required|trim|max_length[150]',
            [
                'required' =>
                    'Sumber dana wajib diisi.',
                'max_length' =>
                    'Sumber dana maksimal 150 karakter.'
            ]
        );

        $this->form_validation->set_rules(
            'nominal',
            'Nominal',
            'required|callback__valid_nominal',
            [
                'required' =>
                    'Nominal wajib diisi.'
            ]
        );

        $this->form_validation->set_rules(
            'metode_pembayaran',
            'Metode Pembayaran',
            'required|in_list[tunai,transfer]',
            [
                'required' =>
                    'Metode pembayaran wajib dipilih.',
                'in_list' =>
                    'Metode pembayaran tidak valid.'
            ]
        );

        $this->form_validation->set_rules(
            'keterangan',
            'Keterangan',
            'trim|max_length[1000]',
            [
                'max_length' =>
                    'Keterangan maksimal 1000 karakter.'
            ]
        );
    }


    // ================================================================
    // PRIVATE: VALIDATE NOMINAL
    // ================================================================

    public function _valid_nominal($value)
    {
        $nominal = $this->_clean_nominal($value);

        if ($nominal <= 0) {

            $this->form_validation->set_message(
                '_valid_nominal',
                'Nominal harus berupa angka dan lebih dari 0.'
            );

            return false;
        }

        return true;
    }


    // ================================================================
    // PRIVATE: CLEAN NOMINAL
    // ================================================================

    private function _clean_nominal($value)
    {
        if ($value === null || $value === '') {
            return 0;
        }

        // Hanya ambil angka
        $value = preg_replace(
            '/[^0-9]/',
            '',
            $value
        );

        if ($value === '') {
            return 0;
        }

        return (int) $value;
    }


    // ================================================================
    // PRIVATE: VALIDATE DATE
    // ================================================================

    public function _valid_date($date)
    {
        $format = 'Y-m-d';

        $date_object =
            DateTime::createFromFormat(
                $format,
                $date
            );

        if (
            !$date_object ||
            $date_object->format($format) !== $date
        ) {

            $this->form_validation->set_message(
                '_valid_date',
                'Format tanggal tidak valid.'
            );

            return false;
        }

        return true;
    }


    // ================================================================
    // PRIVATE: UPLOAD BUKTI
    // ================================================================

    private function _upload_bukti()
    {
        $path =
            FCPATH .
            'uploads/bukti_zis/';


        // ------------------------------------------------------------
        // CREATE DIRECTORY
        // ------------------------------------------------------------
        if (!is_dir($path)) {

            if (!mkdir($path, 0755, true)) {

                $this->session->set_flashdata(
                    'error',
                    'Folder upload tidak dapat dibuat.'
                );

                return false;
            }
        }


        // ------------------------------------------------------------
        // UPLOAD CONFIG
        // ------------------------------------------------------------
        $config = [
            'upload_path'      => $path,
            'allowed_types'    => 'jpg|jpeg|png|webp|pdf',
            'max_size'         => 2048,
            'encrypt_name'     => true,
            'remove_spaces'    => true,
            'detect_mime'      => true,
            'mod_mime_fix'     => true,
            'file_ext_tolower' => true
        ];


        $this->load->library(
            'upload',
            $config
        );


        // ------------------------------------------------------------
        // UPLOAD
        // ------------------------------------------------------------
        if (
            !$this->upload->do_upload('bukti')
        ) {

            $error =
                strip_tags(
                    $this->upload->display_errors()
                );

            $this->session->set_flashdata(
                'error',
                $error
            );

            return false;
        }


        // ------------------------------------------------------------
        // RETURN FILE NAME
        // ------------------------------------------------------------
        $upload =
            $this->upload->data();

        return $upload['file_name'];
    }


    // ================================================================
    // PRIVATE: RENDER FORM
    // ================================================================

    private function _render_form(
        $data,
        $error = null
    ) {
        if ($error) {
            $data['form_error'] = $error;
        }

        $this->load->view(
            'penerimaan/form',
            $data
        );
    }
}