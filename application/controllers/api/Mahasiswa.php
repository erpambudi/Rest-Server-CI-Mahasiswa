<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->model('M_Mahasiswa', 'm_mahasiswa'); //parameter kedua adalah nama lain

        $this->methods['index_get']['limit'] = 1000;
    }

    public function index_get(){

        $id = $this->get('id');

        if($id == null){
            $mahasiswa = $this->m_mahasiswa->getMahasiswa();
        }else{
            $mahasiswa = $this->m_mahasiswa->getMahasiswa($id);
        }

        if($mahasiswa){
        
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ], REST_Controller::HTTP_OK);
        
        }else{

            $this->response([
                'status' => false,
                'message' => 'data not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        
        }

    }

    public function index_delete(){
        
        $id = $this->delete('id');

        if($id == null){

            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        
        }else{
            if($this->m_mahasiswa->deleteMahasiswa($id) > 0){
                
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'id deleted'
                ], REST_Controller::HTTP_NO_CONTENT);
                
            }else{

                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            
            }
        }
    }

    public function index_post(){

        $data = [
            'nrp' => $this-> post('nrp'),
            'nama' => $this-> post('nama'),
            'email' => $this-> post('email'),
            'jurusan' => $this-> post('jurusan')
        ];

        if($this->m_mahasiswa->createMahasiswa($data) > 0 ){
            $this->response([
                'status' => true,
                'message' => 'new mahasiswa created!'
            ], REST_Controller::HTTP_CREATED);
        
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        
        }
    
    }

    public function index_put(){

        $id = $this->put('id');

        $data = [
            'nrp' => $this-> put('nrp'),
            'nama' => $this-> put('nama'),
            'email' => $this-> put('email'),
            'jurusan' => $this-> put('jurusan')
        ];

        if($this->m_mahasiswa->updateMahasiswa($data, $id) > 0 ){
            $this->response([
                'status' => true,
                'message' => 'Mahasiswa has been updated!'
            ], REST_Controller::HTTP_NO_CONTENT);
        
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed to update data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        
        }

    }

}