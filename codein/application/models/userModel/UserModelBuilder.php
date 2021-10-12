<?php
    class UserModelBuilder extends CI_Model{
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
        public function getList(){
            $this->db->select("id, username,fullname, birth_of_day, is_active");
            $query = $this->db->get('tbl_users');  
            if($query->num_rows()>0)
                return $query->result_array();
            return false;

        }

        
        public function getByName($data){
            $this->db->where('username', $data['key']); 
            $query = $this->db->get('tbl_users');  
            if($query->num_rows()>0)
                return $query->result_array();
             return false;
        }

        public function insert_api($data) {
            $this->db->insert('tbl_users', $data);

            if($this->db->affected_rows() > 0)
            {
                return true;
                }
                else
                {
                return false;
            }
        }
        

        public function fetch_single_user($user_id) {
             $this->db->where("id", $user_id);
             $query = $this->db->get('tbl_users');
             return $query->result_array();
        }
        public  function update_api($user_id, $data){
             $this->db->where("id", $user_id);
             $this->db->update("tbl_users", $data);
            }
            
        public   function delete_single_user($user_id){
             $this->db->where("id", $user_id);
             $this->db->delete("tbl_users");
             if($this->db->affected_rows() > 0)
             {
              return true;
             }
             else
             {
              return false;
             }
            }


    }

?>