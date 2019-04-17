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