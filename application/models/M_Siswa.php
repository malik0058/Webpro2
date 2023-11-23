<?php
    class M_Siswa extends CI_Model
    {
        function fetch_all()
        {
            $query = $this->db->get('siswa');
            return $query->result_array();
        }
        function check_data($id)
        {
            $this->db->where("id", $id);
            $query = $this->db->get('siswa');

            if ($query->row()) {
                return true;
            } else {
                return false;
            }
        }

        function insert_api($data)
        {
            $this->db->insert('siswa', $data);
            if ($this->db->affected_rows() > 0){
                return true;
            } else {
                return false;
            }
        }

        function update_data($id, $data)
        {
            $this->db->where("id", $id);
            $this->db->update("siswa", $data);
        }
        function delete_data($id)
        {
            $this->db->where("id", $id);
            $this->db->delete("siswa");
            if ($this->db->affected_row() >0){
                return true;
            } else {
                return false;
            }
        }
    }
?>