<?php
    class UserModel extends CI_Model{
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
        public function getList(){
            $query = $this->db->query('select * from tbl_users');
            if($query->num_rows()>0)
                return $query->result_array();
            return false;

        }

        public function getById($id){
            $query = $this->db->query('select * from tbl_users where username = ?',array($id));
            if($query->num_rows()>0)
                return $query->result_array();
             return false;
        }

        public function addUser($data){
            $sql = 'insert into tbl_users(`id`, `username`, `password`, `fullname`, `birth_of_day`, `avatar`, `is_active`, `created_time`, `updated_time`)
                    values(?,?,?,?,?,?,?,?,?)';
            $result = $this->db->query($sql,
            array($data['id'],$data['username'],$data['password'],$data['fullname'],$data['birth_of_day'],$data['avatar'],$data['is_active'],$data['created_time'],$data['updated_time']));
            return $result;
        }

    }

?>