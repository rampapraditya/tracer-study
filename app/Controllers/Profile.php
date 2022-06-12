<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

/**
 * Description of Profile
 *
 * @author RAMPA
 */
class Profile extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_in")){
            $data['username'] = session()->get("username");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".session()->get("username")."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists(ROOTPATH.'public/uploads/'.$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }
            $data['foto_profile'] = $def_foto;
            
            
            // membaca logo
            $def_logo = base_url().'/images/noimg.jpg';
            $logo = $this->model->getAllQR("select logo from identitas;")->logo;
            if(strlen($logo) > 0){
                if(file_exists(ROOTPATH.'public/uploads/'.$logo)){
                    $def_logo = base_url().'/uploads/'.$logo;
                }
            }
            $data['logo'] = $def_logo;
            
            //$data['korps'] = $this->model->getAll("korps");
            //$data['pangkat'] = $this->model->getAll("pangkat");
            
            // mencari nrp
            $data['nrp'] = $this->model->getAllQR("select nrp from users where idusers = '" . $data['username'] . "';")->nrp;
            
            $cek_detil = $this->model->getAllQR("SELECT count(*) as jml FROM users_detil where idusers = '" . $data['username'] . "';")->jml;
            if ($cek_detil > 0) {
                $detil_pers = $this->model->getAllQR("SELECT * FROM users_detil where idusers = '" . $data['username'] . "';");
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
            echo view('profile/index');
            echo view('foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if(session()->get("logged_in")){
            $idusers = session()->get("username");
            
            // update untuk head
            $data = array(
                'nrp' => $this->request->getVar('nrp'),
                'nama' => $this->request->getVar('nama')
            );
            $kond['idusers'] = $idusers;
            $this->model->update("users",$data,$kond);
            
            // cek untuk detil
            $cek = $this->model->getAllQR("select count(*) as jml from users_detil where idusers = '".$idusers."';")->jml;
            if($cek > 0){
                $data_detil = array(
                    'tgl_lahir' => $this->request->getVar('tgllahir'),
                    'agama' => $this->request->getVar('agama')
                );
                $update = $this->model->update("users_detil",$data_detil,$kond);
                
            }else{
                $data_detil = array(
                    'idusers_detil' => $this->model->autokode("D", "idusers_detil", "users_detil", 2, 7),
                    'idusers' => $idusers,
                    'tgl_lahir' => $this->request->getVar('tgllahir'),
                    'agama' => $this->request->getVar('agama')
                );
                $update = $this->model->add("users_detil",$data_detil);
            }
            
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
