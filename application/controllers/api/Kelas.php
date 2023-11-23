<?php

    defined('BASEPATH') OR exit('No direct sript access allowed');

    require APPPATH . '/libraries/REST_Controller.php';
    use Restserver\Libraries\REST_Controller;

    class Kelas extends REST_Controller {
        function __construct($config = 'rest'){
            parent::__construct($config);
            $this->load->database();//optional
            $this->load->model('M_Kelas');
            $this->load->library('form_validation');
        }
        function fetch_all()
        {
            $this->db->order_by('id', 'DESC');

            $query = $this->db->get('kelas');

            return $query->result_array();
        }
        function fetch_single_data($id)
        {
            $this->db->where("id", $id);
            $query = $this->db->get('kelas');

            return $query->row();
        }
        function index_get()
        {
            $id = $this->get('id');
            if ($id == ''){
                $data = $this->M_Kelas->fetch_all();
            } else {
                $data = $this->M_Kelas->fetch_single_data($id);
            }

            $this->response($data, 200);
        }
        function index_post()
        {
            if ($this->post('kode kelas') == '') {
                $response = array(
                    'status' => 'fail',
                    'field' => 'kode kelas',
                    'message' => 'Isian kode kelas tidak boleh kosong!',
                );

                return $this->response($response);
            }
            if ($this->post('nama kelas') == '') {
                $response = array(
                    'status' => 'fail',
                    'field' => 'nama kelas',
                    'message' => 'Isian nama kelas tidak boleh kosong!',
                    'status_code' => 502
                );

                return $this->response($response);
            }

     
            $data = array(
                'class_code' => trim($this->put('kode kelas')),
                'class_name' => trim($this->put('nama kelas')),
                'created_at' => date('Y-m-d H:i:s'),  
                'updated_at' => date('Y-m-d H:i:s') 
            );
            
            $this->M_Kelas->insert_api($data);
            $last_row = $this->db->select('*')->order_by('id',"desc")->limit(1)->get('kelas')->row();
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
            $check = $this->M_Kelas->check_data($id);
            if ($check == false){
                $error = array(
                    'status' => 'fail',
                    'field' => 'id',
                    'message' => 'Data tidak ditemukan!',
                    'status_code' => 502
                );

                return $this->response($error);
            }
            if ($this->put('kode kelas') == '') {
                $response = array(
                    'status' => 'fail',
                    'field' => 'kode kelas',
                    'message' => 'Isian kode kelas tidak boleh kosong!',
                    'status_code' => 502
                );

                return $this->response($response);
            }

            if ($this->put('nama kelas') == ''){
                $response = array(
                    'status' => 'fail',
                    'field' => 'nama kelas',
                    'message' => 'Isian nama kelas tidak boleh kosong!',
                    'status_code' => 502
                );

                 return $this->response($response);
            }
            $data = array(
                'class_code' => trim($this->post('kode kelas')),
                'class_name' => trim($this->post('nama kelas')),
                'created_at' => date('Y-m-d H:i:s'),  
                'updated_at' => date('Y-m-d H:i:s') 
            );

            $this->M_Kelas->update_data($id,$data);
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
            $check = $this->M_Kelas->check_data($id);
            if ($check == false){
                $error = array(
                    'status' => 'fail',
                    'field' => 'id',
                    'message' => 'Data tidak ditemukan!',
                    'status_code' => 502
                );

                return $this->response($error);

            }
            $delete = $this->M_Kelas->delete_data($id);
            $response = array(
                'status' => 'success',
                'data' => null,
                'status_code' => 200,
            );

            return $this->response($response);
        }   
    }
?>