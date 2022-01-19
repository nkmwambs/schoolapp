<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once FCPATH."vendor/autoload.php";

use AfricasTalking\SDK\AfricasTalking;

class Sms_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    //COMMON FUNCTION FOR SENDING SMS
    function send_sms($message = '' , $reciever_phone = '')
    {
        $active_sms_service = $this->db->get_where('settings' , array(
            'type' => 'active_sms_service'
        ))->row()->description;
        if ($active_sms_service == '' || $active_sms_service == 'disabled')
            return;
		if ($active_sms_service == 'africastalking') {
            return $this->send_sms_via_africastalking($message , $reciever_phone );
        }
        if ($active_sms_service == 'clickatell') {
            $this->send_sms_via_clickatell($message , $reciever_phone );
        }
        if ($active_sms_service == 'twilio') {
            $this->send_sms_via_twilio($message , $reciever_phone );
        }
    }
   	
	 // SEND SMS VIA Africastalking API
    function send_sms_via_africastalking($message = '' , $reciever_phone = '') {

        $account_apikey   = $this->db->get_where('settings', array('type' => 'africastalking_api_id'))->row()->description;
        $username     = $this->db->get_where('settings', array('type' => 'africastalking_user'))->row()->description;
        $from     = '';//$this->db->get_where('settings', array('type' => 'africastalking_sender_id'))->row()->description;
		        
                    // $this->config->set_item('username', $username);
                    // $this->config->set_item('apiKey', $account_apikey);
                    // $this->config->set_item('default_country_code', '+254');
                    // $this->config->set_item('sms_sender', '');  //Leave as NULL to send using the default senderId 'AFRICASTKNG'
                    
                    // // LOAD AT LIBRARY
                    // $this->load->library('AfricasTalking');

                    // return $this->africastalking->sendMessage($reciever_phone, $message);
                    
        $username = $username; // use 'sandbox' for development in the test environment
        $apiKey   = $account_apikey; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);

        // Get one of the services
        $sms      = $AT->sms();

        // Use the service
        $result   = $sms->send([
            'to'      => $reciever_phone,
            'message' => $message,
            'from' => $from,
        ]);

        $result['status'] == 'success' ? "All messages have been sent successfully" : "Message were not sent";
        
        return $result;
    } 
   
    // SEND SMS VIA CLICKATELL API
    function send_sms_via_clickatell($message = '' , $reciever_phone = '') {
        
        $clickatell_user       = $this->db->get_where('settings', array('type' => 'clickatell_user'))->row()->description;
        $clickatell_password   = $this->db->get_where('settings', array('type' => 'clickatell_password'))->row()->description;
        $clickatell_api_id     = $this->db->get_where('settings', array('type' => 'clickatell_api_id'))->row()->description;
        $clickatell_baseurl    = "http://api.clickatell.com";

        $text   = urlencode($message);
        $to     = $reciever_phone;

        // auth call
        $url = "$clickatell_baseurl/http/auth?user=$clickatell_user&password=$clickatell_password&api_id=$clickatell_api_id";

        // do auth call
        $ret = file($url);

        // explode our response. return string is on first line of the data returned
        $sess = explode(":",$ret[0]);
        print_r($sess);echo '<br>';
        if ($sess[0] == "OK") {

            $sess_id = trim($sess[1]); // remove any whitespace
            $url = "$clickatell_baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";

            // do sendmsg call
            $ret = file($url);
            $send = explode(":",$ret[0]);
            print_r($send);echo '<br>';
            if ($send[0] == "ID") {
                echo "successnmessage ID: ". $send[1];
            } else {
                echo "send message failed";
            }
        } else {
            echo "Authentication failure: ". $ret[0];
        }
    }
    
    
    // SEND SMS VIA TWILIO API
    function send_sms_via_twilio($message = '' , $reciever_phone = '') {
        
        // LOAD TWILIO LIBRARY
        require_once(APPPATH . 'libraries/twilio_library/Twilio.php');


        $account_sid    = $this->db->get_where('settings', array('type' => 'twilio_account_sid'))->row()->description;
        $auth_token     = $this->db->get_where('settings', array('type' => 'twilio_auth_token'))->row()->description;
        $client         = new Services_Twilio($account_sid, $auth_token); 

        $client->account->messages->create(array( 
            'To'        => $reciever_phone, 
            'From'      => $this->db->get_where('settings', array('type' => 'twilio_sender_phone_number'))->row()->description,
            'Body'      => $message   
        ));

    }
}