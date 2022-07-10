<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;


/**
 * Description of Profilenoadmin
 *
 * @author RAMPA
 */
class Profilenoadmin extends BaseController {
    
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_no_admin")){
            $data['username'] = session()->get("username");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            
            $idusers = session()->get("username");
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".$idusers."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists($this->modul->getPathApp().$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }
            $data['foto_profile'] = $def_foto;
            
            
            // membaca logo
            $def_logo = base_url().'/images/noimg.jpg';
            $logo = $this->model->getAllQR("select logo from identitas;")->logo;
            if(strlen($logo) > 0){
                if(file_exists($this->modul->getPathApp().$logo)){
                    $def_logo = base_url().'/uploads/'.$logo;
                }
            }
            $data['logo'] = $def_logo;
            $data['def_tgl'] = $this->modul->TanggalSekarang();
            $data['defimg'] = base_url().'/images/noimg.jpg';
            $data['pangkat'] = $this->model->getAllQ("select * from pangkat where idpangkat <> 'P00001';");
            $data['korps'] = $this->model->getAllQ("select * from korps where idkorps <> 'K00000';");
            
            $data['idusers'] = $idusers;
            $personil = $this->model->getAllQR("select * from users where idusers = '" . $idusers . "';");
            $data['pers_head'] = $personil;
            
            // foto personil
            $foto_personil = base_url().'/images/noimg.jpg';
            if (strlen($personil->foto) > 0) {
                if (file_exists($this->modul->getPathApp().$personil->foto)) {
                    $foto_personil = base_url().'/uploads/'.$personil->foto;
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

            // membaca tentang deskripsi diri
            $cek_deskripsi = $this->model->getAllQR("SELECT count(*) as jml FROM deskripsi_diri where idusers = '".$idusers."';")->jml;
            if($cek_deskripsi > 0){
                $data['deskripsi_diri'] = $this->model->getAllQR("SELECT deskripsi FROM deskripsi_diri where idusers = '".$idusers."';")->deskripsi;
            }else{
                $data['deskripsi_diri'] = "";
            }
            
            echo view('head', $data);
            echo view('menu_no_admin');
            echo view('profile/no_admin');
            echo view('foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function prosestab1() {
        if (session()->get("logged_no_admin")) {
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
        if (session()->get("logged_no_admin")) {
            $idusers = $this->request->getVar('idusers');
            
            // membuat folder berdasarkan idusers
            if($this->modul->folder_exist($this->modul->getPathApp().$idusers)){
                $this->modul->buat_folder($this->modul->getPathApp().$idusers);
            }
            
            $logo = $this->model->getAllQR("select foto from users where idusers = '".$idusers."';")->foto;
            if (strlen($logo) > 0) {
                if (file_exists($this->modul->getPathApp().$logo)) {
                    unlink($this->modul->getPathApp().$logo);
                }
            }

            $file = $this->request->getFile('file');
            $namaFile = $file->getRandomName();
            $info_file = $this->modul->info_file($file);

            // cek nama file ada apa tidak
            if (file_exists($this->modul->getPathApp().$idusers.'/'.$namaFile)) {
                $status = "Gunakan nama file lain";
            } else {
                $status_upload = $file->move($this->modul->getPathApp().$idusers, $namaFile);
                if ($status_upload) {
                    $data = array(
                        'foto' => $idusers.'/'.$namaFile
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
        if (session()->get("logged_no_admin")) {
            $idusers = $this->request->uri->getSegment(3);
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".$idusers."';")->foto;           
            if (strlen($foto) > 0) {
                if (file_exists($this->modul->getPathApp().$foto)) {
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }
            echo json_encode(array("foto" => $def_foto));
        } else {
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist_p_umum() {
        if(session()->get("logged_no_admin")){
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
                $val[] = '<img src="'. base_url().'/'.$this->modul->getPathApp().$row->file.'" style="cursor: pointer; width: 100px; height: auto;" class="img-thumbnail" onclick="showimg('."'".$row->idpendidikan."'".','."'umum'".')">';
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
    
    
}
