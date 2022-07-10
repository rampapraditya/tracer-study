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
    
    public function proses() {
        if(session()->get("logged_no_admin")){
            $idusers = session()->get("username");
            
            $data = array(
                'nrp' => $this->request->getVar('nrp'),
                'nama' => $this->request->getVar('nama'),
                'tgl_lahir' => $this->request->getVar('tgllahir'),
                'agama' => $this->request->getVar('agama'),
                'kota_asal' => $this->request->getVar('kota'),
                'satuan_kerja' => $this->request->getVar('satker')
            );
            $kond['idusers'] = $idusers;
            $update = $this->model->update("users",$data,$kond);
            if($update == 1){
                $status = "Profile tersimpan";
            }else{
                $status = "Profile gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
}
