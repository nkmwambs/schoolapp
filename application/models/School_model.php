<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    //COMMON FUNCTION FOR SENDING SMS
    function lowest_class_numeric()
    {
        $numeric = $this->db->select_min('name_numeric')->get('class')->row()->name_numeric;
		
		return $this->db->get_where('class',array('name_numeric'=>$numeric))->row()->class_id;
    }
	
	function highest_class_numeric()
    {
    	 $numeric = $this->db->select_max('name_numeric')->get('class')->row()->name_numeric;
		
		return $this->db->get_where('class',array('name_numeric'=>$numeric))->row()->class_id;
    }
   
}