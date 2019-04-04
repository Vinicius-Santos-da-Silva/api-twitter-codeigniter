<?php
if ( ! function_exists('debug'))
{

	function debug($svar, $die = false)
	{
		$obj =& get_instance();

		if(!$obj->input->is_cli_request()){
			echo "<pre>"; print_r($svar);echo PHP_EOL;echo "</pre>";
		}else{
			print_r($svar);echo PHP_EOL;
		}

		if($die)
			die();
	
	}
}

