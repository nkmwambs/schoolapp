<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

   /*
     *	@author 	: Nicodemus Karisa Mwambire
     *	date		: 16th June, 2018
     *	Techsys School Management System
     *	https://www.techsysolutions.com
     *	support@techsysolutions.com
     */


if ( ! function_exists('get_access_class'))
{
	function get_access_class($phrase = '',$login_type="",$parent_phrase="") {
		$CI	=&	get_instance();
		$CI->load->database();
			
		
		$login_type_id = $CI->db->get_where("login_type",array("name"=>$login_type))->row()->login_type_id;
		
		$derivative_id = 0;
		
		if($parent_phrase!=""){
			
			$check_parent = $CI->db->get_where("entitlement",
			array("name"=>$parent_phrase,"login_type_id"=>$login_type_id))->num_rows();
			
			if($check_parent > 0){
				$derivative_id = $CI->db->get_where("entitlement",
				array("name"=>$parent_phrase,"login_type_id"=>$login_type_id))->row()->entitlement_id;
			}else{
				$data['name'] = $parent_phrase;
				$data['login_type_id'] = $login_type_id;
				$data['derivative_id'] = 0;
				
				$CI->db->insert('entitlement' , $data);	
				
				$derivative_id =  $CI->db->insert_id();
			}
			
			
		}
		
		$check_phrase	=	$CI->db->get_where('entitlement' , 
			array('name' => $phrase,"login_type_id"=>$login_type_id,'derivative_id'=>$derivative_id));//->row()->phrase;
		
		if ( $check_phrase->num_rows() == 0){
			
			$data['name'] = $phrase;
			$data['login_type_id'] = $login_type_id;
			$data['derivative_id'] = $derivative_id;
			$data['visibility'] = 1;
			
			$CI->db->insert('entitlement' , $data);
		}	

		
		return $phrase;
	}
}

