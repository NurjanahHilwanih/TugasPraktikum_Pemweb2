<?php
class Matakuliah extends CI_Controller{
    // METHOD MATAKULIAH
    public function index(){
        // akses model matakuliah
        $this->load->model('matakuliah_model');
        $matakuliah = $this->matakuliah_model->getAll();
        $data['matakuliah'] = $matakuliah;
        // render data dan kirim data ke dalam view
        $this->load->view('layouts/header'); 
        $this->load->view('matakuliah/index_matakuliah', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/footer'); 
    }
    public function detail_matakuliah($id){
        // akses model matakuliah
        $this->load->model('matakuliah_model');
        $matakuliah = $this->matakuliah_model->getById($id);
        $data['matakuliah'] = $matakuliah;
        // render data dan kirim data ke dalam view
        $this->load->view('layouts/header'); 
        $this->load->view('matakuliah/detail_matakuliah', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/footer');
    }
     // Baru3
     public function form_matakuliah(){
        $this->load->view('layouts/header');
        $this->load->view('matakuliah/form_matakuliah');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/footer');
    }
    public function save_matakuliah(){
        // akses ke model matakuliah
        $this->load->model('matakuliah_model','matakuliah'); //1
        $_nama = $this->input->post('nama');
        $_sks = $this->input->post('sks');
        $_kode = $this->input->post('kode');
        $_dosen = $this->input->post('dosen');

       $data_matakuliah['nama'] = $_nama; //2
       $data_matakuliah['sks'] = $_sks;
       $data_matakuliah['kode'] = $_kode;
       $data_matakuliah['dosen'] = $_dosen;

       if((!empty($_idedit))){  //update
           $data_matakuliah['id'] = $_idedit;
           $this->matakuliah->update($data_matakuliah);
       }else{
        //    data baru
        $this->matakuliah->simpan($data_matakuliah);
       }
       redirect('matakuliah','refresh');
    }
    public function edit_matakuliah($id){
        // akses model matakuliah
        $this->load->model('matakuliah_model','matakuliah');
        $obj_matakuliah = $this->matakuliah->getById($id);
        $data['obj_matakuliah'] = $obj_matakuliah;
        $this->load->view('layouts/header');
        $this->load->view('matakuliah/edit_matakuliah', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/footer');
    }
    public function delete_matakuliah($id){
        $this->load->model('matakuliah_model','matakuliah');
        // Mengecek data matakuliah berdasarkan id
        $data_matakuliah['id'] = $id;
        $this->matakuliah->delete($data_matakuliah);
        redirect('matakuliah','refresh');
    }
    public function __construct(){
        parent:: __construct();
        if(!$this->session->userdata('username')){
            redirect('/login');
        }
    }

    public function upload(){
        $_idmatakuliah = $this->input->post("idmatakuliah");
        // akses obj model
        $this->load->model('matakuliah_model','matakuliah');
        $matakuliah = $this->matakuliah->getById($_idmatakuliah);
        $data['matakuliah'] = $matakuliah;

        $config ['upload_path'] = './uploads/photos';
        $config ['allowed_types'] = 'jpg|png';
        $config ['max_size'] = 2894;
        $config ['max_width'] = 2894;
        $config ['max_height'] = 2894;
        $config ['file_name'] = $matakuliah->id;

        // menginisialisasi file upload
        $this->load->library('upload',$config);

        if(!$this->upload->do_upload('foto')){
            $data['error'] = $this->upload->display_errors();
        }else{
            $data['upload_data'] = $this->upload->data();
            $data['error'] = 'Data Sukses';
        }

        // render atau kirim ke view
        $this->load->view('layouts/header'); 
        $this->load->view('matakuliah/detail_matakuliah', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/footer');
    }
}
?>