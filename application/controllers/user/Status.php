<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {

    private $_data;

    public function __construct(){

        parent::__construct();

        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, TRUE);

        $this->validationCheck($data['ApiRequest']);

		$this->_data = $data['ApiRequest'];

		$this->load->model('user/Status_model','sm');

    }

    public function validationCheck($request_data) {

    	//name
		$pattern = array(
			 'name'=>array('/^[가-힣a-zA-Z]+$/')
			,'nick_name'=>array('/^[a-z]+$/')
			,'phone'=>array('/^[0-9]+$/')
		);

		$replace_pattern = array('');

		if(isset($request_data['name']) && preg_replace($pattern['name'], $replace_pattern, $request_data['name'])):
			$this->rc->errorCode(1001);
		endif;

		//nick_name
		if(isset($request_data['nick_name']) && preg_replace($pattern['nick_name'], $replace_pattern, $request_data['nick_name'])):
			$this->rc->errorCode(1001);
		endif;

		//password
		if(isset($request_data['password']) && !preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[~!@#$%^&*()_+]).{10,16}/', $request_data['password'])):
			$this->rc->errorCode(1001);
		endif;

		//phone
		if(isset($request_data['phone']) && preg_replace($pattern['phone'], $replace_pattern, $request_data['phone'])):
			$this->rc->errorCode(1001);
		endif;

	}

    //POST
    public function insertUser() {

    	$result = $this->sm->insertUser($this->_data);

    	if($result===true):
			$this->rc->errorCode(200);
		else:
			$this->rc->errorCode(1002);
		endif;

    }

    //PUT
    public function updateUser() {

		$result = $this->sm->updateUser($this->_data);

		if($result===true):
			$this->rc->errorCode(200);
		else:
			$this->rc->errorCode(1002);
		endif;

    }

    //DELETE
    public function deleteUser() {

		$result = $this->sm->deleteUser($this->_data);

		if($result===true):
			$this->rc->errorCode(200);
		else:
			$this->rc->errorCode(1002);
		endif;

    }

    //GET
    public function getUser() {

		$result['User'] = $this->sm->getUser($this->_data);

		if(!empty($result['User'])):
			$this->rc->errorCode(200,'',$result);
		else:
			$this->rc->errorCode(1003);
		endif;

    }

    //GET
    public function getUserList() {

		$result['UserList'] = $this->sm->getUserList($this->_data);

		if(!empty($result['UserList'])):
			$this->rc->errorCode(200,'',$result);
		else:
			$this->rc->errorCode(1003);
		endif;

    }


}
