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
			$derivative_id = $CI->db->get_where("entitlement",
			array("name"=>$parent_phrase,"login_type_id"=>$login_type_id))->row()->entitlement_id;
		}
		
				
		/** insert blank phrases initially and populating the language db ***/
		$check_phrase	=	$CI->db->get_where('entitlement' , array('name' => $phrase,"login_type_id"=>$login_type_id));//->row()->phrase;
		
		if ( $check_phrase->num_rows() == 0){
			
			$data['name'] = $phrase;
			$data['login_type_id'] = $login_type_id;
			$data['derivative_id'] = $derivative_id;
			
			$CI->db->insert('entitlement' , $data);
		}	
		
		// query for finding the phrase from `language` table
		$query	=	$CI->db->get_where('entitlement' , array('name' => $phrase,"login_type_id"=>$login_type_id));
		$row   	=	$query->row();	
		
		// return the current sessioned language field of according phrase, else return uppercase spaced word
		return $phrase;
	}
}

// ------------------------------------------------------------------------
/* End of file language_helper.php */
/* Location: ./system/helpers/language_helper.php */