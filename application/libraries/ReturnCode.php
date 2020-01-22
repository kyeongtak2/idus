<?php

class ReturnCode {

	public function errorCode($error_code=404, $message='', $merge_data=array()){

		$error_array = array(
			 200 => 'Success'
			,404 => 'Page not found'
			,1001=> 'Invalid parameter'
			,1002=> 'Database Error'
			,1003=> 'Unknown User'
		);

		$result = array();

		$result['Result']['ErrorCode'] = 404;
		$result['Result']['Message'] = $error_array[404];

		if(array_key_exists($error_code, $error_array) !== FALSE):
			$result['Result']['ErrorCode'] = $error_code;
			$result['Result']['Message'] = $message != '' ? $message : $error_array[$error_code];

			if(!empty($merge_data)):
				$result = array_merge($result, $merge_data);
			endif;

		endif;

		header('Content-Type: application/json');
		print_r(json_encode($result));
		exit;

	}

}
