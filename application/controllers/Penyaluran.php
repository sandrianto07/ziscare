<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyaluran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $this->load->model([
            'Penyaluran_model',
            'Dashboard_model',
            'Mustahik_model'
        ]);

        $this->load->library([
            'session',
            'form_validation',
            'upload'
        ]);

        $this->load->helper([
            'url',
            'form',
            'html'
        ]);
    }

    private function get_current_user()
    {
        $user = $this->Dashboard_model->get_user(
            $this->session->userdata('user_id')
        );

        if (!$user) {
            $this->session->sess_destroy();
            redirect('login');
            exit;
        }

        return $user;
    }

    public function index()
    {
        $data = [
            'title' => 'Penyaluran ZIS | ZIS Care',
            'page_title' => 'Penyaluran ZIS',
            'user' => $this->get_current_user(),
            'data' => $this->Penyaluran_model->get_all()
        ];

        $this->load->view('penyaluran/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Penyaluran | ZIS Care',
            'page_title' => 'Tambah Penyaluran',
            'user' => $this->get_current_user(),
            'mode' => 'tambah',
            'data' => null,
            'data_mustahik' => $this->Mustahik_model->get_all()
        ];

        $this->load->view('penyaluran/form', $data);
    }

    public function simpan()
    {
        $this->set_validation();

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata(
                'error',
                validation_errors()
            );

            redirect('penyaluran/tambah');
            return;
        }

        $mustahik_id = $this->input->post('mustahik_id', true);
        $mustahik = $this->Mustahik_model->get_by_id($mustahik_id);

        if (!$mustahik) {
            $this->session->set_flashdata(
                'error',
                'Data mustahik tidak ditemukan.'
            );

            redirect('penyaluran/tambah');
            return;
        }

        $jenis_zis = strtolower(
            trim($this->input->post('jenis_zis', true))
        );

        if ($jenis_zis === 'infaq') {
            $jenis_zis = 'infak';
        }

        if (!in_array($jenis_zis, ['zakat', 'infak', 'sedekah'], true)) {
            $this->session->set_flashdata(
                'error',
                'Jenis ZIS tidak valid.'
            );

            redirect('penyaluran/tambah');
            return;
        }

        $nominal = $this->get_nominal();

        if ($nominal <= 0) {
            $this->session->set_flashdata(
                'error',
                'Nominal penyaluran harus lebih dari 0.'
            );

            redirect('penyaluran/tambah');
            return;
        }

        $saldo = $this->Penyaluran_model->get_saldo_by_jenis(
            $jenis_zis
        );

        if ($nominal > $saldo) {
            $nama_jenis = $this->Penyaluran_model->get_nama_jenis(
                $jenis_zis
            );

            $this->session->set_flashdata(
                'error',
                'Saldo ' . $nama_jenis . ' tidak mencukupi. Saldo ' .
                $nama_jenis . ' tersedia Rp ' .
                number_format($saldo, 0, ',', '.') . '.'
            );

            redirect('penyaluran/tambah');
            return;
        }

        $user = $this->get_current_user();

        $data = [
            'kode_penyaluran' => $this->Penyaluran_model->generate_kode(),
            'tanggal' => $this->input->post('tanggal', true),
            'jenis_zis' => $jenis_zis,
            'kategori_penerima' => $this->input->post(
                'kategori_penerima',
                true
            ),
            'mustahik_id' => $mustahik_id,
            'nominal' => $nominal,
            'metode_penyaluran' => $this->input->post(
                'metode_penyaluran',
                true
            ),
            'keterangan' => $this->input->post(
                'keterangan',
                true
            ),
            'status' => 'tersalurkan',
            'created_by' => $user['id']
        ];

        $bukti = $this->_upload_bukti();

        if ($bukti !== false) {
            $data['bukti'] = $bukti;
        }

        if ($this->Penyaluran_model->insert($data)) {
            $this->session->set_flashdata(
                'success',
                'Data penyaluran berhasil ditambahkan.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'Data penyaluran gagal ditambahkan.'
            );
        }

        redirect('penyaluran');
    }

    public function edit($id)
    {
        $data_penyaluran = $this->Penyaluran_model->get_by_id($id);

        if (!$data_penyaluran) {
            $this->session->set_flashdata(
                'error',
                'Data penyaluran tidak ditemukan.'
            );

            redirect('penyaluran');
            return;
        }

        $data = [
            'title' => 'Edit Penyaluran | ZIS Care',
            'page_title' => 'Edit Penyaluran',
            'user' => $this->get_current_user(),
            'mode' => 'edit',
            'data' => $data_penyaluran,
            'data_mustahik' => $this->Mustahik_model->get_all()
        ];

        $this->load->view('penyaluran/form', $data);
    }

    public function update($id)
    {
        $data_penyaluran = $this->Penyaluran_model->get_by_id($id);

        if (!$data_penyaluran) {
            $this->session->set_flashdata(
                'error',
                'Data penyaluran tidak ditemukan.'
            );

            redirect('penyaluran');
            return;
        }

        $this->set_validation();

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata(
                'error',
                validation_errors()
            );

            redirect('penyaluran/edit/' . $id);
            return;
        }

        $mustahik_id = $this->input->post('mustahik_id', true);
        $mustahik = $this->Mustahik_model->get_by_id($mustahik_id);

        if (!$mustahik) {
            $this->session->set_flashdata(
                'error',
                'Data mustahik tidak ditemukan.'
            );

            redirect('penyaluran/edit/' . $id);
            return;
        }

        $jenis_zis = strtolower(
            trim($this->input->post('jenis_zis', true))
        );

        if ($jenis_zis === 'infaq') {
            $jenis_zis = 'infak';
        }

        if (!in_array($jenis_zis, ['zakat', 'infak', 'sedekah'], true)) {
            $this->session->set_flashdata(
                'error',
                'Jenis ZIS tidak valid.'
            );

            redirect('penyaluran/edit/' . $id);
            return;
        }

        $nominal = $this->get_nominal();

        if ($nominal <= 0) {
            $this->session->set_flashdata(
                'error',
                'Nominal penyaluran harus lebih dari 0.'
            );

            redirect('penyaluran/edit/' . $id);
            return;
        }

        $saldo = $this->Penyaluran_model->get_saldo_by_jenis_for_update(
            $jenis_zis,
            $id
        );

        if ($nominal > $saldo) {
            $nama_jenis = $this->Penyaluran_model->get_nama_jenis(
                $jenis_zis
            );

            $this->session->set_flashdata(
                'error',
                'Saldo ' . $nama_jenis . ' tidak mencukupi. Saldo ' .
                $nama_jenis . ' tersedia Rp ' .
                number_format($saldo, 0, ',', '.') . '.'
            );

            redirect('penyaluran/edit/' . $id);
            return;
        }

        $data = [
            'tanggal' => $this->input->post('tanggal', true),
            'jenis_zis' => $jenis_zis,
            'kategori_penerima' => $this->input->post(
                'kategori_penerima',
                true
            ),
            'mustahik_id' => $mustahik_id,
            'nominal' => $nominal,
            'metode_penyaluran' => $this->input->post(
                'metode_penyaluran',
                true
            ),
            'keterangan' => $this->input->post(
                'keterangan',
                true
            )
        ];

        $bukti_baru = $this->_upload_bukti();

        if ($bukti_baru !== false) {
            if (!empty($data_penyaluran->bukti)) {
                $old_file = FCPATH .
                    'uploads/bukti_penyaluran/' .
                    $data_penyaluran->bukti;

                if (file_exists($old_file)) {
                    @unlink($old_file);
                }
            }

            $data['bukti'] = $bukti_baru;
        }

        if ($this->Penyaluran_model->update($id, $data)) {
            $this->session->set_flashdata(
                'success',
                'Data penyaluran berhasil diperbarui.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'Data penyaluran gagal diperbarui.'
            );
        }

        redirect('penyaluran');
    }

    public function hapus($id)
    {
        if (!$this->Penyaluran_model->get_by_id($id)) {
            $this->session->set_flashdata(
                'error',
                'Data penyaluran tidak ditemukan.'
            );

            redirect('penyaluran');
            return;
        }

        if ($this->Penyaluran_model->delete($id)) {
            $this->session->set_flashdata(
                'success',
                'Data penyaluran berhasil dihapus.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'Data penyaluran gagal dihapus.'
            );
        }

        redirect('penyaluran');
    }

    public function get_saldo_jenis()
    {
        $jenis_zis = $this->input->get('jenis_zis', true);

        if (!$jenis_zis) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Jenis ZIS wajib dipilih.'
                ]));

            return;
        }

        $jenis_zis = strtolower(trim($jenis_zis));

        if ($jenis_zis === 'infaq') {
            $jenis_zis = 'infak';
        }

        if (!in_array($jenis_zis, ['zakat', 'infak', 'sedekah'], true)) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Jenis ZIS tidak valid.'
                ]));

            return;
        }

        $saldo = $this->Penyaluran_model->get_saldo_by_jenis(
            $jenis_zis
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'jenis_zis' => $jenis_zis,
                'nama_jenis' => $this->Penyaluran_model->get_nama_jenis(
                    $jenis_zis
                ),
                'saldo' => $saldo,
                'saldo_format' => 'Rp ' . number_format(
                    $saldo,
                    0,
                    ',',
                    '.'
                )
            ]));
    }

    private function set_validation()
    {
        $this->form_validation->set_rules(
            'tanggal',
            'Tanggal',
            'required'
        );

        $this->form_validation->set_rules(
            'jenis_zis',
            'Jenis ZIS',
            'required|in_list[zakat,infak,sedekah]'
        );

        $this->form_validation->set_rules(
            'mustahik_id',
            'Nama Penerima',
            'required|numeric'
        );

        $this->form_validation->set_rules(
            'kategori_penerima',
            'Kategori Penyaluran',
            'required|in_list[Beasiswa,Santunan,Bantuan Pendidikan,Bantuan Kesehatan,Bantuan Sosial,Bantuan Ekonomi,Kegiatan Keagamaan,Pemberdayaan Masyarakat,Lainnya]'
        );

        $this->form_validation->set_rules(
            'nominal',
            'Nominal',
            'required'
        );

        $this->form_validation->set_rules(
            'metode_penyaluran',
            'Metode Penyaluran',
            'required|in_list[tunai,transfer,barang]'
        );
    }

    private function get_nominal()
    {
        return (float) preg_replace(
            '/[^0-9]/',
            '',
            $this->input->post('nominal', true)
        );
    }

    private function _upload_bukti()
    {
        if (empty($_FILES['bukti']['name'])) {
            return false;
        }

        $upload_path = FCPATH . 'uploads/bukti_penyaluran/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $this->upload->initialize([
            'upload_path' => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|webp|pdf',
            'max_size' => 2048,
            'encrypt_name' => true
        ]);

        if (!$this->upload->do_upload('bukti')) {
            $this->session->set_flashdata(
                'error',
                $this->upload->display_errors('', '')
            );

            return false;
        }

        return $this->upload->data('file_name');
    }
}