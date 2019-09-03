<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

    /*
     *	@author 	: Nicodemus Karisa Mwambire
     *	date		: 16th June, 2018
     *	Techsys School Management System
     *	https://www.techsysolutions.com
     *	support@techsysolutions.com
     */
//require 'vendor/autoload.php';

//use AfricasTalking\SDK\AfricasTalking;

class Settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        //$this->db->db_select($this->session->app);
        //$this->load->library('Africastalking');

        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function school_settings($param1="", $param2="")
    {
        if ($this->session->userdata('active_login') != 1) {
            redirect(base_url() . 'index.php?login', 'refresh');
        }

        if ($param1==='add_term') {
            $data['name']=$this->input->post('term');
            $data['name_number']=$this->input->post('term_number');
            $data['start_month']=$this->input->post('start_month');
            $data['end_month']=$this->input->post('end_month');

            $this->db->insert('terms', $data);

            $this->session->set_flashdata('flash_message', get_phrase('term_added'));
            redirect(base_url() . 'index.php?settings/school_settings/', 'refresh');
        }
        if ($param1==='edit_term') {
            $this->db->where(array('terms_id'=>$param2));

            $data['name'] = $this->input->post('term');
            $data['term_number'] = $this->input->post('term_number');
            $data['start_month']=$this->input->post('start_month');
            $data['end_month']=$this->input->post('end_month');

            $this->db->update('terms', $data);

            $this->session->set_flashdata('flash_message', get_phrase('term_editted'));
            redirect(base_url() . 'index.php?settings/school_settings/', 'refresh');
        }
        if ($param1=='delete_term') {
            $this->db->where(array('terms_id'=>$param2));

            $this->db->delete('terms');

            $this->session->set_flashdata('flash_message', get_phrase('term_deleted'));
            redirect(base_url() . 'index.php?settings/school_settings/', 'refresh');
        }

        if ($param1==='add_relationship') {
            $msg = get_phrase('duplicate_name');
            $data['name']=$this->input->post('name');

            if ($this->db->get_where("relationship", array("name"=>$this->input->post('name')))->num_rows() === 0) {
                $msg = get_phrase('record_added');
                $this->db->insert('relationship', $data);
            }


            $this->session->set_flashdata('flash_message', $msg);
            redirect(base_url() . 'index.php?settings/school_settings/', 'refresh');
        }

        if ($param1=='delete_relationship') {
            $this->db->where(array('relationship_id'=>$param2));

            $this->db->delete('relationship');

            $this->session->set_flashdata('flash_message', get_phrase('record_deleted'));
            redirect(base_url() . 'index.php?settings/school_settings/', 'refresh');
        }

        if ($param1==='edit_relationship') {
            $msg = get_phrase('duplicate_record');

            if ($this->db->get_where("relationship", array("name"=>$this->input->post('name')))->num_rows() === 0) {
                $this->db->where(array('relationship_id'=>$param2));
                $data['name'] = $this->input->post('name');
                $this->db->update('relationship', $data);
                $msg = get_phrase('record_edited');
            }

            $this->session->set_flashdata('flash_message', $msg);
            redirect(base_url() . 'index.php?settings/school_settings/', 'refresh');
        }

        //Check if there is a financial month close

        $approved_reports_count_obj = $this->db->get_where('reconcile', array('status'=>1));

        $approved_reports_count = 0;

        if($approved_reports_count_obj->num_rows() > 0 ){
          $approved_reports_count = $approved_reports_count_obj->num_rows();
        }

        $page_data['approved_reports_exists'] = $approved_reports_count > 0?true:false;
        $page_data['terms'] = $this->db->get('terms')->result_object();
        $page_data['page_name']                 = 'school_settings';
        $page_data['page_view'] = "settings";
        $page_data['page_title']                = get_phrase('school_settings');
        $this->load->view('backend/index', $page_data);
    }

    /*****SITE/SYSTEM SETTINGS*********/
    public function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('active_login') != 1) {
            redirect(base_url() . 'index.php?login', 'refresh');
        }

        if ($param1 == 'do_update') {
            $data['description'] = $this->input->post('system_name');
            $this->db->where('type', 'system_name');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('system_title');
            $this->db->where('type', 'system_title');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('address');
            $this->db->where('type', 'address');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('phone');
            $this->db->where('type', 'phone');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('paypal_email');
            $this->db->where('type', 'paypal_email');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('currency');
            $this->db->where('type', 'currency');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('system_email');
            $this->db->where('type', 'system_email');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type', 'system_name');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('language');
            $this->db->where('type', 'language');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('text_align');
            $this->db->where('type', 'text_align');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('system_start_date');
            $this->db->where('type', 'system_start_date');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('sidebar-collapsed');
            $this->db->where('type', 'sidebar-collapsed');
            $this->db->update('settings', $data);

            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?settings/system_settings/', 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?settings/system_settings/', 'refresh');
        }
        if ($param1 == 'change_skin') {
            $data['description'] = $param2;
            $this->db->where('type', 'skin_colour');
            $this->db->update('settings', $data);
            $this->session->set_flashdata('flash_message', get_phrase('theme_selected'));
            redirect(base_url() . 'index.php?settings/system_settings/', 'refresh');
        }

        $page_data['page_name']  = 'system_settings';
        $page_data['page_view']  = 'settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /*****SMS SETTINGS*********/
    public function sms_settings($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('active_login') != 1) {
            redirect(base_url() . 'index.php?login', 'refresh');
        }

        if ($param1 == 'africastalking') {
            $data['description'] = $this->input->post('africastalking_user');
            $this->db->where('type', 'africastalking_user');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('africastalking_api_id');
            $this->db->where('type', 'africastalking_api_id');
            $this->db->update('settings', $data);

            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?settings/sms_settings/', 'refresh');
        }

        if ($param1 == 'clickatell') {
            $data['description'] = $this->input->post('clickatell_user');
            $this->db->where('type', 'clickatell_user');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('clickatell_password');
            $this->db->where('type', 'clickatell_password');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('clickatell_api_id');
            $this->db->where('type', 'clickatell_api_id');
            $this->db->update('settings', $data);

            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?settings/sms_settings/', 'refresh');
        }

        if ($param1 == 'twilio') {
            $data['description'] = $this->input->post('twilio_account_sid');
            $this->db->where('type', 'twilio_account_sid');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('twilio_auth_token');
            $this->db->where('type', 'twilio_auth_token');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('twilio_sender_phone_number');
            $this->db->where('type', 'twilio_sender_phone_number');
            $this->db->update('settings', $data);

            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?settings/sms_settings/', 'refresh');
        }

        if ($param1 == 'active_service') {
            $data['description'] = $this->input->post('active_sms_service');
            $this->db->where('type', 'active_sms_service');
            $this->db->update('settings', $data);

            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?settings/sms_settings/', 'refresh');
        }

        $page_data['page_name']  = 'sms_settings';
        $page_data['page_view']  = 'settings';
        $page_data['page_title'] = get_phrase('sms_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /*****LANGUAGE SETTINGS*********/
    public function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('active_login') != 1) {
            redirect(base_url() . 'index.php?login', 'refresh');
        }

        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile'] 	= $param2;
        }
        if ($param1 == 'update_phrase') {
            $language	=	$param2;
            $total_phrase	=	$this->input->post('total_phrase');
            for ($i = 1 ; $i < $total_phrase ; $i++) {
                //$data[$language]	=	$this->input->post('phrase').$i;
                $this->db->where('phrase_id', $i);
                $this->db->update('language', array($language => $this->input->post('phrase'.$i)));
            }
            redirect(base_url() . 'index.php?settings/manage_language/edit_phrase/'.$language, 'refresh');
        }
        if ($param1 == 'do_update') {
            $language        = $this->input->post('language');
            $data[$language] = $this->input->post('phrase');
            $this->db->where('phrase_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?settings/manage_language/', 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $data['phrase'] = $this->input->post('phrase');
            $this->db->insert('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?settings/manage_language/', 'refresh');
        }
        if ($param1 == 'add_language') {
            $language = $this->input->post('language');
            $this->load->dbforge();
            $fields = array(
                $language => array(
                    'type' => 'LONGTEXT'
                )
            );
            $this->dbforge->add_column('language', $fields);

            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?settings/manage_language/', 'refresh');
        }
        if ($param1 == 'delete_language') {
            $language = $param2;
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $language);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));

            redirect(base_url() . 'index.php?settings/manage_language/', 'refresh');
        }
        $page_data['page_name']        = 'manage_language';
        $page_data['page_view']        = 'settings';
        $page_data['page_title']       = get_phrase('manage_language');
        //$page_data['language_phrases'] = $this->db->get('language')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    public function expense_category($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('active_login') != 1) {
            redirect('login', 'refresh');
        }
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
            $data['income_category_id']   =   $this->input->post('income_category_id');
            $this->db->insert('expense_category', $data);
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?settings/school_settings');
        }
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
            $data['income_category_id'] = $this->input->post('income_category_id');
            $this->db->where('expense_category_id', $param2);
            $this->db->update('expense_category', $data);
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?settings/school_settings');
        }
        if ($param1 == 'delete') {
            $this->db->where('expense_category_id', $param2);
            $this->db->delete('expense_category');
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?settings/school_settings');
        }

        $page_data['page_name']  = 'school_settings';
        $page_data['page_view']  = 'settings';
        $page_data['page_title'] = get_phrase('school_settings');
        $this->load->view('backend/index', $page_data);
    }
    public function income_category($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('active_login') != 1) {
            redirect('login', 'refresh');
        }

        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
            $data['opening_balance']   =   $this->input->post('opening_balance');
            $this->db->insert('income_categories', $data);
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?settings/income_category');
        }
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
            $data['opening_balance']   =   $this->input->post('opening_balance');
            //$data['income_category_id'] = $this->input->post('income_category_id');
            $this->db->where('income_category_id', $param2);
            $this->db->update('income_categories', $data);
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?settings/income_category');
        }
        if ($param1 == 'delete') {
            $this->db->where('income_category_id', $param2);
            $this->db->delete('income_categories');
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?settings/income_category');
        }

        $page_data['page_name']  = 'school_settings';
        $page_data['page_view']  = 'settings';
        $page_data['page_title'] = get_phrase('income_category');
        $this->load->view('backend/index', $page_data);
    }

    public function change_category_status($category_type, $current_status, $category_id)
    {
        $title = get_phrase('income_category');
        $message = "Update not successful";
        $data['status'] = 1;

        if ($current_status == 1) {
            $data['status'] = 0;
        }

        if ($category_type == 'income') {
            $this->db->where(array('income_category_id'=>$category_id));
            $this->db->update('income_categories', $data);
            $message = "Update successful";

            //Deactivate all expense category for this income category if status is changes to 0 or
            //Activate all expense category if status is changed to 1

            $this->db->where(array('income_category_id'=>$category_id));
            $this->db->update('expense_category',$data);

        } else {
            $this->db->where(array('expense_category_id'=>$category_id));
            $this->db->update('expense_category', $data);
            $message = "Update successful";
        }

        $this->session->set_flashdata('flash_message', $message);

        redirect(base_url() . 'index.php?settings/school_settings/', 'refresh');
    }

    public function update_income_category_opening_balance($income_category_id ="")
    {
        $this->db->where(array('income_category_id'=>$income_category_id));
        $data['opening_balance'] = $this->input->post('opening_balance');
        $this->db->update('income_categories', $data);
    }

    public function update_default_category($income_category_id ="")
    {
        //Check if another category is set as default and unset it
        $this->db->update('income_categories', array('default_category'=>0), array('default_category'=>1));

        $this->db->where(array('income_category_id'=>$income_category_id));
        $data['default_category'] = $this->input->post('default_category');
        $this->db->update('income_categories', $data);
    }

    public function opening_balances($param1="", $param2="")
    {
        $this->db->where(array('name'=>'cash'));
        $data['opening_balance'] = $this->input->post('cash');
        $this->db->update('accounts', $data);

        $this->db->where(array('name'=>'bank'));
        $data1['opening_balance'] = $this->input->post('bank');
        $this->db->update('accounts', $data1);

        $this->db->where(array('type'=>'system_start_date'));
        $data2['description'] = $this->input->post('system_start_date');
        $this->db->update('settings', $data2);

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?settings/school_settings/', 'refresh');
    }

    public function user_profiles($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('active_login') != 1) {
            redirect('login', 'refresh');
        }

        if ($param1=="create") {
            $msg = get_phrase('failure');

            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['login_type_id'] = $this->input->post('login_type_id');

            $this->db->insert("profile", $data);

            if ($this->db->affected_rows() > 0) {
                $msg = get_phrase('success');
            }

            $this->session->set_flashdata('flash_message', $msg);
            redirect(base_url() . 'index.php?settings/user_profiles/', 'refresh');
        }

        $page_data['page_name']  = 'user_profiles';
        $page_data['page_view']  = 'settings';
        $page_data['page_title'] = get_phrase('user_profiles');
        $this->load->view('backend/index', $page_data);
    }

    public function entitlement($param1="", $param2="")
    {
        if ($this->session->userdata('active_login') != 1) {
            redirect('login', 'refresh');
        }

        $page_data['page_name']  = 'entitlement';
        $page_data['profile_id']  = $param1;
        $page_data['page_view']  = 'settings';
        $page_data['page_title'] = get_phrase('entitlement');
        $this->load->view('backend/index', $page_data);
    }

    public function update_entitlement($param1="", $param2="", $param3="")
    {
        if ($param3 === 'true') {
            $data['entitlement_id'] = $param1;
            $data['profile_id'] = $param2;
            $this->db->insert("access", $data);
        } else {
            $this->db->where(array("entitlement_id"=>$param1,"profile_id"=>$param2));
            $this->db->delete("access");
        }

        //echo "Update Successful";
    }

    public function promote_to_user($param1="", $param2="")
    {
        if ($param1=="teacher") {
            $teacher = $this->db->get_where("teacher", array("teacher_id"=>$param2))->result_array();
            extract($teacher[0]);

            $name_array = explode(" ", $name);

            $data['firstname'] = array_shift($name_array);
            $data['lastname'] = implode(" ", $name_array);
            $data['email'] = $email;
            $data['password'] = md5("default");
            $data['phone'] = $phone;
            $data['login_type_id'] = $this->db->get_where("login_type", array("name"=>"teacher"))->row()->login_type_id;
            $data['profile_id'] = 0;
            $data['type_user_id'] = $teacher_id;
            $data['auth'] = 1;

            $msg = get_phrase("failed");

            /**Check if exists**/
            $exists = $this->db->get_where("user", array("email"=>$email))->num_rows();
            if ($exists == 0) {
                $this->db->insert("user", $data);
                $msg = get_phrase("success");
            }

            $this->session->set_flashdata('flash_message', $msg);
            redirect(base_url() . 'index.php?teacher/teacher/', 'refresh');
        }

        if ($param1=="admin") {
            $admin = $this->db->get_where("admin", array("admin_id"=>$param2))->result_array();
            extract($admin[0]);

            $name_array = explode(" ", $name);

            $password = substr(md5(rand(100000000, 20000000000)), 0, 7);

            $data['firstname'] = array_shift($name_array);
            $data['lastname'] = implode(" ", $name_array);
            $data['email'] = $email;
            $data['password'] = md5($password);
            $data['phone'] = $phone;
            $data['login_type_id'] = $this->db->get_where("login_type", array("name"=>"admin"))->row()->login_type_id;
            $data['profile_id'] = 1;
            $data['type_user_id'] = $admin_id;
            $data['auth'] = 1;

            $msg = get_phrase("failed");

            /**Check if exists**/
            $exists = $this->db->get_where("user", array("email"=>$email))->num_rows();
            if ($exists == 0) {
                $this->db->insert("user", $data);
                $msg = get_phrase("success");
                $this->email_model->account_opening_email('admin', $email, $password);
            }

            $this->session->set_flashdata('flash_message', $msg);
            redirect(base_url() . 'index.php?admin/admin/', 'refresh');
        }
    }
}
