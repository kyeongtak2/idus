<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_model extends CI_Model {

	private $_idus = null;

	public function __construct(){

		parent::__construct();

		$this->_idus = $this->load->database('idus', true);

	}

	public function __destruct(){

		$this->_idus->close();

	}

	public function insertUser($data){

		$data['password'] = md5($data['password']);

		return $this->_idus->insert('t_users',$data);

	}

	public function updateUser($data){

		$where = array("email"=>$data['email']);
		$this->_idus->where($where);

		return $this->_idus->replace('t_users', $data);

	}

	public function deleteUser($data){

		$where = array("email"=>$data['email']);
		$this->_idus->where($where);

		return $this->_idus->delete('t_users');

	}

	public function getUser($data){

		$where = array("email"=>$data['email']);

		$this->_idus->select('
			 email as Email
			,name as Name
			,phone as Phone
			,nick_name as NickName
			,recommend_code as RecommendCode
			,gender_type as GenderType
			,terms_conditions_flag as TermsConditionsFlag
			,privacy_policy_flag as PrivacyPolicyFlag
			,event_alarm_flag as EventAlarmFlag
		');
		$this->_idus->from('t_users');
		$this->_idus->where($where);

		$query = $this->_idus->get();
		$result = $query->row_array();

		return $result;

	}

	public function getUserList($data){

		$page = isset($data['page']) && !empty($data['page']) ? $data['page'] : 0;
		$page = $page <= 0 ? 0 : $page-1;

		$size = isset($data['size']) && !empty($data['size']) ? $data['size'] : 15;

		$start = $page*$size;

		$this->_idus->select('
			 seq as Seq
			,email as Email
			,name as Name
			,phone as Phone
			,nick_name as NickName
			,recommend_code as RecommendCode
			,gender_type as GenderType
			,terms_conditions_flag as TermsConditionsFlag
			,privacy_policy_flag as PrivacyPolicyFlag
			,event_alarm_flag as EventAlarmFlag
			,crdt as CreateDate 
		');
		$this->_idus->from('t_users');

		$this->_idus->order_by("seq DESC");
		$this->_idus->limit($size, $start);

		$query = $this->_idus->get();
		$result = $query->result_array();

		return $result;

	}

}
