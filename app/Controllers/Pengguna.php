<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

/**
 * Description of Pengguna
 *
 * @author RAMPA
 */
class Pengguna extends BaseController {

    private $model;
    private $modul;

    public function __construct() {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function index() {
        if (session()->get("logged_in")) {
            $data['username'] = session()->get("username");
            $data['nrp'] = session()->get('nrp');
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");

            // membaca foto profile
            $def_foto = base_url() . '/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("username") . "';")->foto;
            if (strlen($foto) > 0) {
                if (file_exists(ROOTPATH . 'public/uploads/' . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            // membaca logo
            $def_logo = base_url() . '/images/noimg.jpg';
            $logo = $this->model->getAllQR("select logo from identitas;")->logo;
            if (strlen($logo) > 0) {
                if (file_exists(ROOTPATH . 'public/uploads/' . $logo)) {
                    $def_logo = base_url() . '/uploads/' . $logo;
                }
            }
            $data['logo'] = $def_logo;

            $data['role'] = $this->model->getAll("role");
            $data['korps'] = $this->model->getAll("korps");
            $data['pangkat'] = $this->model->getAll("pangkat");

            echo view('head', $data);
            echo view('menu');
            echo view('pengguna/index');
            echo view('foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if (session()->get("logged_in")) {
            $data = array();
            $list = $this->model->getAllQ("select a.idusers, a.nrp, b.nama_role, a.nama, c.nama_pangkat, d.nama_korps 
                from users a, role b, pangkat c, korps d 
                where a.idrole = b.idrole and a.idpangkat = c.idpangkat and a.idkorps = d.idkorps;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->nrp;
                $val[] = $row->nama_role;
                $val[] = $row->nama;
                $val[] = $row->nama_pangkat;
                $val[] = $row->nama_korps;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-success btn-fw" onclick="detil(' . "'" . $this->modul->enkrip_url($row->idusers) . "'" . ')">Detil</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti(' . "'" . $row->idusers . "'" . ')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus(' . "'" . $row->idusers . "'" . ',' . "'" . $row->nrp . "'" . ',' . "'" . $row->nama . "'" . ')">Hapus</button>'
                        . '</div>';

                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add() {
        if (session()->get("logged_in")) {
            $jml = $this->model->getAllQR("select count(*) as jml from users where nrp = '" . $this->request->getVar('nrp') . "';")->jml;
            if ($jml > 0) {
                $status = "NRP sudah ada";
            } else {
                $data = array(
                    'idusers' => $this->model->autokode("U", "idusers", "users", 2, 7),
                    'nrp' => $this->request->getVar('nrp'),
                    'pass' => $this->modul->enkrip_pass($this->request->getVar('pass')),
                    'nama' => $this->request->getVar('nama'),
                    'idrole' => $this->request->getVar('role'),
                    'idkorps' => $this->request->getVar('korps'),
                    'idpangkat' => $this->request->getVar('pangkat')
                );
                $simpan = $this->model->add("users", $data);
                if ($simpan == 1) {
                    $status = "Data tersimpan";
                } else {
                    $status = "Data gagal tersimpan";
                }
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ganti() {
        if (session()->get("logged_in")) {
            $kondisi['idusers'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("users", $kondisi);

            echo json_encode(array(
                "kode" => $data->idusers,
                "nrp" => $data->nrp,
                "nama" => $data->nama,
                "pass" => $this->modul->dekrip_pass($data->pass),
                "idrole" => $data->idrole,
                "idkorps" => $data->idkorps,
                "idpangkat" => $data->idpangkat
            ));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit() {
        if (session()->get("logged_in")) {
            $data = array(
                'pass' => $this->modul->enkrip_pass($this->request->getVar('pass')),
                'nama' => $this->request->getVar('nama'),
                'idrole' => $this->request->getVar('role'),
                'idkorps' => $this->request->getVar('korps'),
                'idpangkat' => $this->request->getVar('pangkat')
            );
            $kond['idusers'] = $this->request->getVar('kode');
            $update = $this->model->update("users", $data, $kond);
            if ($update == 1) {
                $status = "Data terupdate";
            } else {
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapus() {
        if (session()->get("logged_in")) {
            $kondisi['idusers'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("users", $kondisi);
            if ($hapus == 1) {
                $status = "Data terhapus";
            } else {
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function detil() {
        if (session()->get("logged_in")) {
            $data['username'] = session()->get("username");
            $data['nrp'] = session()->get('nrp');
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['defimg'] = base_url().'/images/noimg.jpg';

            // membaca foto profile
            $def_foto = base_url() . '/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("username") . "';")->foto;
            if (strlen($foto) > 0) {
                if (file_exists(ROOTPATH . 'public/uploads/' . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            // membaca logo
            $def_logo = base_url() . '/images/noimg.jpg';
            $logo = $this->model->getAllQR("select logo from identitas;")->logo;
            if (strlen($logo) > 0) {
                if (file_exists(ROOTPATH . 'public/uploads/' . $logo)) {
                    $def_logo = base_url() . '/uploads/' . $logo;
                }
            }
            $data['logo'] = $def_logo;
            $data['pangkat'] = $this->model->getAllQ("select * from pangkat where idpangkat <> 'P00001';");
            $data['korps'] = $this->model->getAllQ("select * from korps where idkorps <> 'K00000';");

            // data personil
            $idusers = $this->modul->dekrip_url($this->request->uri->getSegment(3));
            $cek_idusers = $this->model->getAllQR("select count(*) as jml from users where idusers = '" . $idusers . "';")->jml;
            if ($cek_idusers > 0) {
                $data['idusers'] = $idusers;

                $personil = $this->model->getAllQR("select * from users where idusers = '" . $idusers . "';");
                $data['pers_head'] = $personil;
                // ini untuk bagian dalam
                $foto_personil = base_url() . '/images/noimg.jpg';
                if (strlen($personil->foto) > 0) {
                    if (file_exists(ROOTPATH . 'public/uploads/' . $personil->foto)) {
                        $foto_personil = base_url() . '/uploads/' . $personil->foto;
                    }
                }
                $data['foto_personil'] = $foto_personil;

                // detil personil
                $cek_detil = $this->model->getAllQR("SELECT count(*) as jml FROM users_detil where idusers = '" . $idusers . "';")->jml;
                if ($cek_detil > 0) {
                    $detil_pers = $this->model->getAllQR("SELECT * FROM users_detil where idusers = '" . $idusers . "';");
                    $data['dinas_pangkat'] = $detil_pers->ms_dinas_pngkt;
                    $data['tmt_tni'] = $detil_pers->tmt_tni;
                    $data['ms_dinas_prajurit'] = $detil_pers->ms_dinas_prajurit;
                    $data['tmp_lahir'] = $detil_pers->tmp_lahir;
                    $data['tgl_lahir'] = $detil_pers->tgl_lahir;
                    $data['suku'] = $detil_pers->suku;
                    $data['jabatan'] = $detil_pers->jabatan;
                    $data['lama_jabatan'] = $detil_pers->lama_jabatan;
                    $data['alamat'] = $detil_pers->alamat;
                    $data['tmt_fiktif'] = $detil_pers->tmt_fiktif;
                    $data['jkel'] = $detil_pers->jkel;
                    $data['agama'] = $detil_pers->agama;
                } else {
                    $data['dinas_pangkat'] = "";
                    $data['tmt_tni'] = "";
                    $data['ms_dinas_prajurit'] = "";
                    $data['tmp_lahir'] = "";
                    $data['tgl_lahir'] = "";
                    $data['suku'] = "";
                    $data['jabatan'] = "";
                    $data['lama_jabatan'] = "";
                    $data['alamat'] = "";
                    $data['tmt_fiktif'] = "";
                    $data['jkel'] = "";
                    $data['agama'] = "";
                }

                echo view('head', $data);
                echo view('menu');
                echo view('pengguna/detil');
                echo view('foot');
            } else {
                $this->modul->halaman('pengguna');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function prosestab1() {
        if (session()->get("logged_in")) {
            $cek = $this->model->getAllQR("SELECT count(*) as jml FROM users_detil where idusers = '" . $this->request->getVar('idusers') . "';")->jml;
            if ($cek > 0) {
                $status = $this->update();
            } else {
                $status = $this->simpan();
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function simpan() {
        $data = array(
            'idusers_detil' => $this->model->autokode("D", "idusers_detil", "users_detil", 2, 7),
            'idusers' => $this->request->getVar('idusers'),
            'ms_dinas_pngkt' => $this->request->getVar('dinas_pangkat'),
            'tmt_tni' => $this->request->getVar('tmt_tni'),
            'ms_dinas_prajurit' => $this->request->getVar('dinas_tni'),
            'tmp_lahir' => $this->request->getVar('tmp_lahir'),
            'tgl_lahir' => $this->request->getVar('tgl_lahir'),
            'suku' => $this->request->getVar('suku'),
            'jabatan' => $this->request->getVar('jabatan'),
            'lama_jabatan' => $this->request->getVar('lama_jab'),
            'alamat' => $this->request->getVar('alamat'),
            'tmt_fiktif' => $this->request->getVar('tmt_fiktif'),
            'agama' => $this->request->getVar('agama'),
            'jkel' => $this->request->getVar('jkel'),
        );
        $simpan = $this->model->add("users_detil", $data);
        if ($simpan == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        return $status;
    }

    private function update() {
        $data = array(
            'ms_dinas_pngkt' => $this->request->getVar('dinas_pangkat'),
            'tmt_tni' => $this->request->getVar('tmt_tni'),
            'ms_dinas_prajurit' => $this->request->getVar('dinas_tni'),
            'tmp_lahir' => $this->request->getVar('tmp_lahir'),
            'tgl_lahir' => $this->request->getVar('tgl_lahir'),
            'suku' => $this->request->getVar('suku'),
            'jabatan' => $this->request->getVar('jabatan'),
            'lama_jabatan' => $this->request->getVar('lama_jab'),
            'alamat' => $this->request->getVar('alamat'),
            'tmt_fiktif' => $this->request->getVar('tmt_fiktif'),
            'agama' => $this->request->getVar('agama'),
            'jkel' => $this->request->getVar('jkel'),
        );
        $kond['idusers'] = $this->request->getVar('idusers');
        $update = $this->model->update("users_detil", $data, $kond);
        if ($update == 1) {
            $status = "Data terupdate";
        } else {
            $status = "Data gagal terupdate";
        }
        return $status;
    }

    public function prose_upload_foto() {
        if (session()->get("logged_in")) {
            $idusers = $this->request->getVar('idusers');
            
            // membuat folder berdasarkan idusers
            if($this->modul->folder_exist(ROOTPATH . 'public/uploads/' . $idusers)){
                $this->modul->buat_folder(ROOTPATH . 'public/uploads/' . $idusers);
            }
            
            $logo = $this->model->getAllQR("select foto from users where idusers = '".$idusers."';")->foto;
            if (strlen($logo) > 0) {
                if (file_exists(ROOTPATH . 'public/uploads/'.$logo)) {
                    unlink(ROOTPATH . 'public/uploads/'.$logo);
                }
            }

            $file = $this->request->getFile('file');
            $info_file = $this->modul->info_file($file);

            // cek nama file ada apa tidak
            if (file_exists(ROOTPATH . 'public/uploads/'.$idusers.'/'. $info_file['name'])) {
                $status = "Gunakan nama file lain";
            } else {
                $status_upload = $file->move(ROOTPATH . 'public/uploads/' . $idusers);
                if ($status_upload) {
                    $data = array(
                        'foto' => $idusers.'/'.$info_file['name']
                    );
                    $kond['idusers'] = $idusers;
                    $update = $this->model->update("users", $data, $kond);
                    if ($update == 1) {
                        $status = "Foto profile terupload";
                    } else {
                        $status = "Foto profile gagal terupload";
                    }
                } else {
                    $status = "File gagal terupload";
                }
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }
    
    public function load_foto() {
        if (session()->get("logged_in")) {
            $idusers = $this->request->uri->getSegment(3);
            $def_foto = base_url() . '/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".$idusers."';")->foto;           
            if (strlen($foto) > 0) {
                if (file_exists(ROOTPATH . 'public/uploads/' . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            echo json_encode(array("foto" => $def_foto));
        } else {
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist_p_umum() {
        if(session()->get("logged_in")){
            $idusers = $this->request->uri->getSegment(3);
            // load data
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from pend_umum where idusers = '".$idusers."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nm_pendidikan;
                $val[] = $row->tahun;
                $val[] = '<img src="'.$this->modul->getPublicPath().$row->file.'" style="cursor: pointer; width: 100px; height: auto;" class="img-thumbnail" onclick="showimg('."'".$row->idpendidikan."'".','."'umum'".')">';
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="show_pend_umum('."'".$row->idpendidikan."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus_pend_umum('."'".$row->idpendidikan."'".','."'".$row->nm_pendidikan."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
                
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add_pend_umum() {
        if(session()->get("logged_in")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->simpan_pend_umum_file();
                }
            }else{
                $status = $this->simpan_pend_umum();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpan_pend_umum_file() {
        $nm_folder = $this->request->getVar('idusers');
        $file = $this->request->getFile('file');
        $namaFile = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists(ROOTPATH.'public/uploads/'.$nm_folder.'/'.$namaFile)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads/'.$nm_folder, $namaFile);
            if($status_upload){
                $data = array(
                    'idpendidikan' => $this->model->autokode("U","idpendidikan","pend_umum", 2, 7),
                    'idusers' => $this->request->getVar('idusers'),
                    'nm_pendidikan' => $this->request->getVar('nama'),
                    'tahun' => $this->request->getVar('tahun'),
                    'keterangan' => $this->request->getVar('ket'),
                    'file' => $nm_folder.'/'.$namaFile
                );
                $simpan = $this->model->add("pend_umum",$data);
                if($simpan == 1){
                    $status = "Data tersimpan";
                }else{
                    $status = "Data gagal tersimpan";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
    
    private function simpan_pend_umum() {
        $data = array(
            'idpendidikan' => $this->model->autokode("U","idpendidikan","pend_umum", 2, 7),
            'idusers' => $this->request->getVar('idusers'),
            'nm_pendidikan' => $this->request->getVar('nama'),
            'tahun' => $this->request->getVar('tahun'),
            'keterangan' => $this->request->getVar('ket'),
            'file' => ''
        );
        $simpan = $this->model->add("pend_umum", $data);
        if ($simpan == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    public function show_pend_umum() {
        if(session()->get("logged_in")){
            $kondisi['idpendidikan'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("pend_umum", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function show_pend_militer() {
        if(session()->get("logged_in")){
            $kondisi['idpendidikan'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("pend_militer", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit_pend_umum() {
        if(session()->get("logged_in")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->update_pend_umum_file();
                }
            }else{
                $status = $this->update_pend_umum();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function update_pend_umum_file() {
        // hapus file lama
        $file_lawas = $this->model->getAllQR("SELECT file FROM pend_umum where idpendidikan = '".$this->request->getVar('kode')."';")->file;
        $this->modul->hapus_file($file_lawas);
            
        $nm_folder = $this->request->getVar('idusers');
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists(ROOTPATH.'public/uploads/'.$nm_folder.'/'.$fileName)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads/'.$nm_folder, $fileName);
            if($status_upload){
                $data = array(
                    'idusers' => $this->request->getVar('idusers'),
                    'nm_pendidikan' => $this->request->getVar('nama'),
                    'tahun' => $this->request->getVar('tahun'),
                    'keterangan' => $this->request->getVar('ket'),
                    'file' => $nm_folder.'/'.$fileName
                );
                $kond['idpendidikan'] = $this->request->getVar('kode');
                $update = $this->model->update("pend_umum",$data, $kond);
                if($update == 1){
                    $status = "Data terupdate";
                }else{
                    $status = "Data gagal terupdate";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
    
    private function update_pend_umum() {
        $data = array(
            'idusers' => $this->request->getVar('idusers'),
            'nm_pendidikan' => $this->request->getVar('nama'),
            'tahun' => $this->request->getVar('tahun'),
            'keterangan' => $this->request->getVar('ket')
        );
        $kond['idpendidikan'] = $this->request->getVar('kode');
        $update = $this->model->update("pend_umum", $data, $kond);
        if ($update == 1) {
            $status = "Data terupdate";
        } else {
            $status = "Data gagal terupdate";
        }
        return $status;
    }
    
    public function hapuspendumum() {
        if(session()->get("logged_in")){
            $idpendidikan = $this->request->uri->getSegment(3);
            // cek file
            $file_lawas = $this->model->getAllQR("SELECT file FROM pend_umum where idpendidikan = '".$idpendidikan."';")->file;
            $this->modul->hapus_file($file_lawas);
            
            $kond['idpendidikan'] = $idpendidikan;
            $hapus = $this->model->delete("pend_umum",$kond);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist_p_militer() {
        if(session()->get("logged_in")){
            $idusers = $this->request->uri->getSegment(3);
            // load data
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from pend_militer where idusers = '".$idusers."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nm_pendidikan;
                $val[] = $row->tahun;
                $val[] = '<img src="'.$this->modul->getPublicPath().$row->file.'" style="width: 100px; height: auto;" class="img-thumbnail">';
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="show_pend_militer('."'".$row->idpendidikan."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus_pend_militer('."'".$row->idpendidikan."'".','."'".$row->nm_pendidikan."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
                
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function load_detil_img() {
        if (session()->get("logged_in")) {
            $kode = $this->request->uri->getSegment(3);
            $mode = $this->request->uri->getSegment(4);
            $def_foto = base_url().'/images/noimg.jpg';
            if($mode == "umum"){
                $foto = $this->model->getAllQR("select file from pend_umum where idpendidikan = '".$kode."';")->file;
            }else if($mode == "militer"){
                $foto = $this->model->getAllQR("select file from pend_militer where idpendidikan = '".$kode."';")->file;
            }
            
            if (strlen($foto) > 0) {
                if (file_exists(ROOTPATH . 'public/uploads/' . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            echo json_encode(array("foto" => $def_foto));
        } else {
            $this->modul->halaman('login');
        }
    }
    
    public function unduhfile() {
        if (session()->get("logged_in")) {
            $kode = $this->request->uri->getSegment(3);
            $mode = $this->request->uri->getSegment(4);
            if($mode == "umum"){
                $foto = $this->model->getAllQR("select file from pend_umum where idpendidikan = '".$kode."';")->file;
            }else if($mode == "militer"){
                $foto = $this->model->getAllQR("select file from pend_militer where idpendidikan = '".$kode."';")->file;
            }
            return $this->response->download('uploads/' . $foto, null);
        }else {
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add_pend_militer() {
        if(session()->get("logged_in")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->simpan_pend_militer_file();
                }
            }else{
                $status = $this->simpan_pend_militer();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpan_pend_militer_file() {
        $nm_folder = $this->request->getVar('idusers');
        $file = $this->request->getFile('file');
        $namaFile = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists(ROOTPATH.'public/uploads/'.$nm_folder.'/'.$namaFile)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads/'.$nm_folder, $namaFile);
            if($status_upload){
                $data = array(
                    'idpendidikan' => $this->model->autokode("M","idpendidikan","pend_militer", 2, 7),
                    'idusers' => $this->request->getVar('idusers'),
                    'nm_pendidikan' => $this->request->getVar('nama'),
                    'tahun' => $this->request->getVar('tahun'),
                    'keterangan' => $this->request->getVar('ket'),
                    'file' => $nm_folder.'/'.$namaFile
                );
                $simpan = $this->model->add("pend_militer",$data);
                if($simpan == 1){
                    $status = "Data tersimpan";
                }else{
                    $status = "Data gagal tersimpan";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
    
    private function simpan_pend_militer() {
        $data = array(
            'idpendidikan' => $this->model->autokode("M","idpendidikan","pend_militer", 2, 7),
            'idusers' => $this->request->getVar('idusers'),
            'nm_pendidikan' => $this->request->getVar('nama'),
            'tahun' => $this->request->getVar('tahun'),
            'keterangan' => $this->request->getVar('ket'),
            'file' => ''
        );
        $simpan = $this->model->add("pend_militer", $data);
        if ($simpan == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    public function ajax_edit_pend_militer() {
        if(session()->get("logged_in")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->update_pend_militer_file();
                }
            }else{
                $status = $this->update_pend_militer();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function update_pend_militer_file() {
        // hapus file lama
        $file_lawas = $this->model->getAllQR("SELECT file FROM pend_militer where idpendidikan = '".$this->request->getVar('kode')."';")->file;
        $this->modul->hapus_file($file_lawas);
            
        $nm_folder = $this->request->getVar('idusers');
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists(ROOTPATH.'public/uploads/'.$nm_folder.'/'.$fileName)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads/'.$nm_folder, $fileName);
            if($status_upload){
                $data = array(
                    'idusers' => $this->request->getVar('idusers'),
                    'nm_pendidikan' => $this->request->getVar('nama'),
                    'tahun' => $this->request->getVar('tahun'),
                    'keterangan' => $this->request->getVar('ket'),
                    'file' => $nm_folder.'/'.$fileName
                );
                $kond['idpendidikan'] = $this->request->getVar('kode');
                $update = $this->model->update("pend_militer",$data, $kond);
                if($update == 1){
                    $status = "Data terupdate";
                }else{
                    $status = "Data gagal terupdate";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
    
    private function update_pend_militer() {
        $data = array(
            'idusers' => $this->request->getVar('idusers'),
            'nm_pendidikan' => $this->request->getVar('nama'),
            'tahun' => $this->request->getVar('tahun'),
            'keterangan' => $this->request->getVar('ket')
        );
        $kond['idpendidikan'] = $this->request->getVar('kode');
        $update = $this->model->update("pend_militer", $data, $kond);
        if ($update == 1) {
            $status = "Data terupdate";
        } else {
            $status = "Data gagal terupdate";
        }
        return $status;
    }
    
    public function hapuspendmiliter() {
        if(session()->get("logged_in")){
            $idpendidikan = $this->request->uri->getSegment(3);
            // cek file
            $file_lawas = $this->model->getAllQR("SELECT file FROM pend_militer where idpendidikan = '".$idpendidikan."';")->file;
            $this->modul->hapus_file($file_lawas);
            
            $kond['idpendidikan'] = $idpendidikan;
            $hapus = $this->model->delete("pend_militer",$kond);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist_b_asing() {
        if(session()->get("logged_in")){
            $idusers = $this->request->uri->getSegment(3);
            // load data
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from b_asing where idusers = '".$idusers."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nm_bahasa;
                $val[] = $row->keterangan;
                $path = "";
                if(strlen($row->file) > 0){
                    if(file_exists($this->modul->pathExits().$row->file)){
                        $path = $this->modul->getPublicPath().$row->file;
                    }
                }
                $val[] = '<img src="'.$path.'" style="width: 100px; height: auto;" class="img-thumbnail">';
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="show_b_asing('."'".$row->idb_asing."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus_b_asing('."'".$row->idb_asing."'".','."'".$row->nm_bahasa."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
                
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist_b_daerah() {
        if(session()->get("logged_in")){
            $idusers = $this->request->uri->getSegment(3);
            // load data
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from b_daerah where idusers = '".$idusers."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nm_bahasa;
                $val[] = $row->keterangan;
                $path = "";
                if(strlen($row->file) > 0){
                    if(file_exists($this->modul->pathExits().$row->file)){
                        $path = $this->modul->getPublicPath().$row->file;
                    }
                }
                $val[] = '<img src="'.$path.'" style="width: 100px; height: auto;" class="img-thumbnail">';
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="show_b_daerah('."'".$row->idb_daerah."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus_b_daerah('."'".$row->idb_daerah."'".','."'".$row->nm_bahasa."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
                
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add_b_asing() {
        if(session()->get("logged_in")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->simpan_b_asing_file();
                }
            }else{
                $status = $this->simpan_b_asing();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpan_b_asing_file() {
        $nm_folder = $this->request->getVar('idusers');
        $file = $this->request->getFile('file');
        $namaFile = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists(ROOTPATH.'public/uploads/'.$nm_folder.'/'.$namaFile)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads/'.$nm_folder, $namaFile);
            if($status_upload){
                $data = array(
                    'idb_asing' => $this->model->autokode("B","idb_asing","b_asing", 2, 7),
                    'idusers' => $this->request->getVar('idusers'),
                    'nm_bahasa' => $this->request->getVar('nama'),
                    'keterangan' => $this->request->getVar('ket'),
                    'file' => $nm_folder.'/'.$namaFile
                );
                $simpan = $this->model->add("b_asing",$data);
                if($simpan == 1){
                    $status = "Data tersimpan";
                }else{
                    $status = "Data gagal tersimpan";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
    
    private function simpan_b_asing() {
        $data = array(
            'idb_asing' => $this->model->autokode("B","idb_asing","b_asing", 2, 7),
            'idusers' => $this->request->getVar('idusers'),
            'nm_bahasa' => $this->request->getVar('nama'),
            'keterangan' => $this->request->getVar('ket'),
            'file' => ''
        );
        $simpan = $this->model->add("b_asing",$data);
        if($simpan == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    public function show_b_asing() {
        if(session()->get("logged_in")){
            $kondisi['idb_asing'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("b_asing", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit_b_asing() {
        if(session()->get("logged_in")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->update_b_asing_file();
                }
            }else{
                $status = $this->update_b_asing();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function update_b_asing_file() {
        // hapus file lama
        $file_lawas = $this->model->getAllQR("SELECT file FROM b_asing where idb_asing = '".$this->request->getVar('kode')."';")->file;
        $this->modul->hapus_file($file_lawas);
            
        $nm_folder = $this->request->getVar('idusers');
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists(ROOTPATH.'public/uploads/'.$nm_folder.'/'.$fileName)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads/'.$nm_folder, $fileName);
            if($status_upload){
                $data = array(
                    'idusers' => $this->request->getVar('idusers'),
                    'nm_bahasa' => $this->request->getVar('nama'),
                    'keterangan' => $this->request->getVar('ket'),
                    'file' => $nm_folder.'/'.$fileName
                );
                $kond['idb_asing'] = $this->request->getVar('kode');
                $update = $this->model->update("b_asing",$data, $kond);
                if($update == 1){
                    $status = "Data terupdate";
                }else{
                    $status = "Data gagal terupdate";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
    
    private function update_b_asing() {
        $data = array(
            'idusers' => $this->request->getVar('idusers'),
            'nm_bahasa' => $this->request->getVar('nama'),
            'keterangan' => $this->request->getVar('ket')
        );
        $kond['idb_asing'] = $this->request->getVar('kode');
        $update = $this->model->update("b_asing", $data, $kond);
        if ($update == 1) {
            $status = "Data terupdate";
        } else {
            $status = "Data gagal terupdate";
        }
        return $status;
    }
    
    public function hapus_b_asing() {
        if(session()->get("logged_in")){
            $kode = $this->request->uri->getSegment(3);
            // cek file
            $file_lawas = $this->model->getAllQR("SELECT file FROM b_asing where idb_asing = '".$kode."';")->file;
            $this->modul->hapus_file($file_lawas);
            
            $kond['idb_asing'] = $kode;
            $hapus = $this->model->delete("b_asing",$kond);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add_b_daerah() {
        if(session()->get("logged_in")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->simpan_b_daerah_file();
                }
            }else{
                $status = $this->simpan_b_daerah();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpan_b_daerah_file() {
        $nm_folder = $this->request->getVar('idusers');
        $file = $this->request->getFile('file');
        $namaFile = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists(ROOTPATH.'public/uploads/'.$nm_folder.'/'.$namaFile)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads/'.$nm_folder, $namaFile);
            if($status_upload){
                $data = array(
                    'idb_daerah' => $this->model->autokode("B","idb_daerah","b_daerah", 2, 7),
                    'idusers' => $this->request->getVar('idusers'),
                    'nm_bahasa' => $this->request->getVar('nama'),
                    'keterangan' => $this->request->getVar('ket'),
                    'file' => $nm_folder.'/'.$namaFile
                );
                $simpan = $this->model->add("b_daerah",$data);
                if($simpan == 1){
                    $status = "Data tersimpan";
                }else{
                    $status = "Data gagal tersimpan";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
    
    private function simpan_b_daerah() {
        $data = array(
            'idb_daerah' => $this->model->autokode("B","idb_daerah","b_daerah", 2, 7),
            'idusers' => $this->request->getVar('idusers'),
            'nm_bahasa' => $this->request->getVar('nama'),
            'keterangan' => $this->request->getVar('ket'),
            'file' => ''
        );
        $simpan = $this->model->add("b_daerah",$data);
        if($simpan == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    public function show_b_daerah() {
        if(session()->get("logged_in")){
            $kond['idb_daerah'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("b_daerah", $kond);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit_b_daerah() {
        if(session()->get("logged_in")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->update_b_daerah_file();
                }
            }else{
                $status = $this->update_b_daerah();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function update_b_daerah_file() {
        // hapus file lama
        $file_lawas = $this->model->getAllQR("SELECT file FROM b_daerah where idb_daerah = '".$this->request->getVar('kode')."';")->file;
        $this->modul->hapus_file($file_lawas);
            
        $nm_folder = $this->request->getVar('idusers');
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists(ROOTPATH.'public/uploads/'.$nm_folder.'/'.$fileName)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads/'.$nm_folder, $fileName);
            if($status_upload){
                $data = array(
                    'idusers' => $this->request->getVar('idusers'),
                    'nm_bahasa' => $this->request->getVar('nama'),
                    'keterangan' => $this->request->getVar('ket'),
                    'file' => $nm_folder.'/'.$fileName
                );
                $kond['idb_daerah'] = $this->request->getVar('kode');
                $update = $this->model->update("b_daerah",$data, $kond);
                if($update == 1){
                    $status = "Data terupdate";
                }else{
                    $status = "Data gagal terupdate";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
    
    private function update_b_daerah() {
        $data = array(
            'idusers' => $this->request->getVar('idusers'),
            'nm_bahasa' => $this->request->getVar('nama'),
            'keterangan' => $this->request->getVar('ket')
        );
        $kond['idb_daerah'] = $this->request->getVar('kode');
        $update = $this->model->update("b_daerah", $data, $kond);
        if ($update == 1) {
            $status = "Data terupdate";
        } else {
            $status = "Data gagal terupdate";
        }
        return $status;
    }
    
    public function hapus_b_daerah() {
        if(session()->get("logged_in")){
            $kode = $this->request->uri->getSegment(3);
            // cek file
            $file_lawas = $this->model->getAllQR("SELECT file FROM b_daerah where idb_daerah = '".$kode."';")->file;
            $this->modul->hapus_file($file_lawas);
            
            $kond['idb_daerah'] = $kode;
            $hapus = $this->model->delete("b_daerah",$kond);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist_r_pangkat() {
        if(session()->get("logged_in")){
            $idusers = $this->request->uri->getSegment(3);
            // load data
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select idriwayat_pangkat, date_format(tanggal, '%d %M %Y') as tgl, b.nama_pangkat, a.keterangan from riwayat_pangkat a, pangkat b where a.idusers = '".$idusers."' and a.idpangkat = b.idpangkat;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tgl;
                $val[] = $row->nama_pangkat;
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="show_r_pangkat('."'".$row->idriwayat_pangkat."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus_r_pangkat('."'".$row->idriwayat_pangkat."'".','."'".$row->nama_pangkat."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
                
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist_r_jabatan() {
        if(session()->get("logged_in")){
            $idusers = $this->request->uri->getSegment(3);
            // load data
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT idr_jab, date_format(tanggal, '%d %M %Y') as tgl, jabatan, keterangan  FROM riwayat_jabatan where idusers = '".$idusers."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tgl;
                $val[] = $row->jabatan;
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="show_r_pangkat('."'".$row->idr_jab."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus_r_pangkat('."'".$row->idr_jab."'".','."'".$row->jabatan."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
                
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
}
