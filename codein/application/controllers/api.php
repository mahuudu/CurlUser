<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    public function __construct(){
        parent::__construct();
		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$this->load->library('form_validation');
		$this->load->helper('form');
        $this->load->model("userModel/UserModelBuilder");
    }


	public function index()
	{
        $this->load->helper('url'); 
        $listData = $this->UserModelBuilder->getList();
		echo json_encode($listData);
        // var_dump($listData);
        // $data['listData'] = $listData;
        // $data['path'] = array('ViewUser/listUser');
		// $this->load->view('listData',$data);

	}

	public function fetchSingle(){
		$_POST = json_decode(file_get_contents("php://input"), true);

		if($this->input->post('id'))
		{
			$data = $this->UserModelBuilder->fetch_single_user($this->input->post('id'));
			if($data){
				echo json_encode($data);
			}else{
				$array = array(
					'error'  => 'Id not exsts'
				);
			}
		}
    }

	public function search($key){
		$data = array(
			'key' => $key
		);
		$listData = $this->UserModelBuilder->getByName($data);

		if($listData){
			echo json_encode($listData);
		}
	}

	public function insert(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		$this->form_validation->set_rules("user_name", "user name ", "required");
		$this->form_validation->set_rules("full_name", "full name", "required");
		$this->form_validation->set_rules("password", "password", "required");
		$this->form_validation->set_rules("birth_of_day", "birth_of_day", "required");
		$this->form_validation->set_rules("avatar", "avatar", "required");
		$array = array();
		
		if($this->form_validation->run())
		{
		
			$user_name = $this->input->post('user_name');
			$full_name  = $this->input->post('full_name');
			$password  = $this->input->post('password');
			$birth_of_day  = $this->input->post('birth_of_day');
			$avatar  = $this->input->post('avatar');
			$is_active = 1;
			$dt = date('Y-m-d h:i:s');

			$data = array(
				'id' => '',
				'username' => $user_name,
				'fullname'  => $full_name,
				'password'  => $password,
				'birth_of_day'  => $birth_of_day,
				'avatar'  => $avatar,
				'is_active' => $is_active,
				'created_time' => $dt,
				'updated_time' => $dt,
			);

			$this->UserModelBuilder->insert_api($data);

			$array = array(
			'success'  => true
			);

		}else{
			$array = array(
				'error'    => true,
				'user_name_error' => form_error('user_name'),
				'full_name_error' => form_error('full_name'),
				'password_error' => form_error('password'),
				'birth_of_day_error' => form_error('birth_of_day'),
				'avatar_error' => form_error('avatar'),
			);
		}
		echo json_encode($array, true);
	}


	public function updateUser(){
		$_POST = json_decode(file_get_contents("php://input"), true);

	
		$this->form_validation->set_rules("id", "id", "required");
		$this->form_validation->set_rules("user_name", "user name ", "required");
		$this->form_validation->set_rules("full_name", "full name", "required");
		$this->form_validation->set_rules("password", "password", "required");
		$this->form_validation->set_rules("birth_of_day", "birth_of_day", "required");
		$this->form_validation->set_rules("avatar", "avatar", "required");
		$array = array();
		
		if($this->form_validation->run())
		{
			$id = $this->input->post('id');
			$user_name = $this->input->post('user_name');
			$full_name  = $this->input->post('full_name');
			$password  = $this->input->post('password');
			$birth_of_day  = $this->input->post('birth_of_day');
			$avatar  = $this->input->post('avatar');
			$is_active = 1;
			$dt = date('Y-m-d h:i:s');

			$data = array(
				'id' => $id,
				'username' => $user_name,
				'fullname'  => $full_name,
				'password'  => $password,
				'birth_of_day'  => $birth_of_day,
				'avatar'  => $avatar,
				'is_active' => $is_active,
				'updated_time' => $dt,
			);

			$this->UserModelBuilder->update_api($id,$data);

			$array = array(
			'success'  => true
			);
			
		}else{
			$array = array(
				'error'    => true,
				'id_error' => form_error('id'),
				'user_name_error' => form_error('user_name'),
				'full_name_error' => form_error('full_name'),
				'password_error' => form_error('password'),
				'birth_of_day_error' => form_error('birth_of_day'),
				'avatar_error' => form_error('avatar'),
			);
		}
		echo json_encode($array, true);
	}

	public function deleteUser(){
		$_POST = json_decode(file_get_contents("php://input"), true);

		if($this->input->post('id')){
			$id = $this->input->post('id');
			$data = $this->UserModelBuilder->fetch_single_user($this->input->post('id'));
			$filename = $data[0]['avatar'];
				if($filename){
					$this->load->helper("file");
					unlink(FCPATH.'uploads/'.$filename);
					if($this->UserModelBuilder->delete_single_user($id))
					{
						$array = array(
						'success' => true
						);
					}else{
						$array = array(
						'error' => true
						);
					}
					echo json_encode($array);
				}
			}
	}

	public function upload(){
	  $config['upload_path'] = './uploads/';
      $config['allowed_types'] = '*';
		
      $this->load->library('upload');
      $this->upload->initialize($config);

      if ( ! $this->upload->do_upload('file'))
      {
        $error = array('error' => $this->upload->display_errors());
		echo json_encode($error);
      }
      else
      {
        $data = array('upload_data' => $this->upload->data());
        json_encode($data);
      }
	}

	public function deleteFile(){
		$this->load->helper("file");
		$_POST = json_decode(file_get_contents("php://input"), true);
		if(isset($_POST)){
			$filename =  $this->input->post('fileName');
			unlink(FCPATH.'uploads/'.$filename);
			echo json_encode('Delete suscces');
		}else{
			echo json_encode('err');
		}
	}



}
