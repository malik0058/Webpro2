<?php

    defined('BASEPATH') OR exit('No direct sript access allowed');

    require APPPATH . '/libraries/REST_Controller.php';
    use Restserver\Libraries\REST_Controller;

    class Siswa extends REST_Controller {
        function __construct($config = 'rest'){
            parent::__construct($config);
            $this->load->database();//optional
            $this->load->model('M_Siswa');
            $this->load->library('form_validation');
        }
        function fetch_all()
        {
            $this->db->order_by('id', 'DESC');

            $query = $this->db->get('siswa');

            return $query->result_array();
        }
        function fetch_single_data($id)
        {
            $this->db->where("id", $id);
            $query = $this->db->get('siswa');

            return $query->row();
        }
        function index_get()
        {
            $id = $this->get('id');
            if ($id == ''){
                $data = $this->M_Siswa->fetch_all();
            } else {
                $data = $this->M_Siswa->fetch_single_data($id);
            }

            $this->response($data, 200);
        }
        function index_post()
        {
            if ($this->post('nama') == '') {
                $response = array(
                    'status' => 'fail',
                    'field' => 'nama',
                    'message' => 'Isian nama tidak boleh kosong!',
                );

                return $this->response($response);
            }
            if ($this->post('id kelas') == '') {
                $response = array(
                    'status' => 'fail',
                    'field' => 'id kelas',
                    'message' => 'Isian id kelas tidak boleh kosong!',
                    'status_code' => 502
                );

                return $this->response($response);
            }
            if ($this->post('gender') == '') {
                $response = array(
                    'status' => 'fail',
                    'field' => 'gender',
                    'message' => 'Isian gender tidak boleh kosong!',
                    'status_code' => 502
                );

                return $this->response($response);
            }
            if ($this->post('alamat') == '') {
                $response = array(
                    'status' => 'fail',
                    'field' => 'alamat',
                    'message' => 'Isian alamat tidak boleh kosong!',
                    'status_code' => 502
                );

                return $this->response($response);
            }

     
            $data = array(
            'name' => $this->post('nama'),
            'class_id' => trim($this->post('id kelas')),
            'date_birth' => trim($this->post('date_birth')),
            'gender' => trim($this->post('gender')),
            'address' => trim($this->post('alamat')),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            );
            $this->M_Siswa->insert_api($data);
            $last_row = $this->db->select('*')->order_by('id',"desc")->limit(1)->get('siswa')->row();
            $response = array(
                'status' => 'succes',
                'data'=> $last_row,
                'status_code' => 201,
            );
            
            return $this->response($response);
        }
        function index_put()
        {
            $id = $this->put('id');
            $check = $this->M_Siswa->check_data($id);
            if ($check == false){
                $error = array(
                    'status' => 'fail',
                    'field' => 'id',
                    'message' => 'Data tidak ditemukan!',
                    'status_code' => 502
                );

                return $this->response->response($error);
            }
            if ($this->put('nama') == '') {
                $response = array(
                    'status' => 'fail',
                    'field' => 'nama',
                    'message' => 'Isian nama tidak boleh kosong!',
                    'status_code' => 502
                );

                return $this->response($response);
            }

            if ($this->put('id kelas') == ''){
                $response = array(
                    'status' => 'fail',
                    'field' => 'nama kelas',
                    'message' => 'Isian id kelas tidak boleh kosong!',
                    'status_code' => 502
                );

                 return $this->response($response);
            }
            if ($this->put('gender') == '') {
                $response = array(
                    'status' => 'fail',
                    'field' => 'gender',
                    'message' => 'Isian gender tidak boleh kosong!',
                    'status_code' => 502
                );

                return $this->response($response);
            }
            if ($this->put('alamat') == '') {
                $response = array(
                    'status' => 'fail',
                    'field' => 'alamat',
                    'message' => 'Isian alamat tidak boleh kosong!',
                    'status_code' => 502
                );

                return $this->response($response);
            }
            $data = array(
                'name' => $this->post('nama'),
                'class_id' => trim($this->post('id kelas')),
                'date_birth' => trim($this->post('date_birth')),
                'gender' => trim($this->post('gender')),
                'address' => trim($this->post('alamat')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->M_Siswa->update_data($id,$data);
            $newData = $this->M_Kelas->fetch_single_data($id);
            $response = array(
                'status' => 'success',
                'data' => $newData,
                'status_code' => 200,
            );

            return $this->response($response);
        }
        function index_delete() {
            $id = $this->delete('id');
            $check = $this->M_Siswa->check_data($id);
            if ($check == false){
                $error = array(
                    'status' => 'fail',
                    'field' => 'id',
                    'message' => 'Data tidak ditemukan!',
                    'status_code' => 502
                );

                return $this->response->response($error);
            }
            $delete = $this->M_Siswa->delete_data($id);
            $response = array(
                'status' => 'success',
                'data' => null,
                'status_code' => 200,
            );

            return $this->response($response);
        }   
    }
?>