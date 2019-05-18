<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

   /*
     *	@author 	: Nicodemus Karisa Mwambire
     *	date		: 16th June, 2018
     *	Techsys School Management System
     *	https://www.techsysolutions.com
     *	support@techsysolutions.com
     */


if ( ! function_exists('get_term_number'))
{
	function get_term_number($month = "") {
		$CI	=&	get_instance();
		$CI->load->database();
		
		$terms = $CI->db->get('terms')->result_object();
		
		$term_number = '';
		
		foreach($terms as $term){
			if($month >= $term->start_month && $month <= $term->end_month){
				$term_number = $term->term_number;
			}
		}
		
		return $term_number;
	}
}	

if(!function_exists('delete_affected_rows_alert')){
	
	function delete_affected_rows_alert(){
		
		$CI	=&	get_instance();
		$CI->load->database();
		
		if($CI->db->affected_rows() > 0){
				$CI->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
			}else{
				$CI->session->set_flashdata('error_message' , get_phrase('data_not_deleted'));
		}
	}

}

if(!function_exists('insert_affected_rows_alert')){
	
	function insert_affected_rows_alert(){
		
		$CI	=&	get_instance();
		$CI->load->database();
		
		if($CI->db->affected_rows() > 0){
				$CI->session->set_flashdata('flash_message' , get_phrase('data_inserted'));
			}else{
				$CI->session->set_flashdata('error_message' , get_phrase('data_not_inserted'));
		}
	}

}

if(!function_exists('update_affected_rows_alert')){
	
	function update_affected_rows_alert(){
		
		$CI	=&	get_instance();
		$CI->load->database();
		
		if($CI->db->affected_rows() > 0){
				$CI->session->set_flashdata('flash_message' , get_phrase('data_updated'));
			}else{
				$CI->session->set_flashdata('error_message' , get_phrase('data_not_updated'));
		}
	}

}		