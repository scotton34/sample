<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  Page created by Stephen Cotton
 *  
 * 
 */

class Passwordreset extends CI_Controller {

    private $username;
    private $passkey;
    private $password;

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    function index() {
        $this->resetLogin();
        $this->fuel->pages->render('password-reset', array('layout' => 'password-reset'));
    }

     /**
      * Created by Stephen Cotton
      * Date 12/11/15
      */
    function resetLogin() {
        //Unset a few sessions
        $this->session->unset_userdata("logged_in");
        $this->session->unset_userdata("model");
        $this->session->unset_userdata("model_year");
        $this->session->unset_userdata("search");
        $this->session->unset_userdata("sort");
    }

    /**
     * Created by Stephen Cotton
     * Date 12/11/15
     */
    public function validate() {
        ($this->session->userdata("passwordreset") === "1") ? redirect("/") : NULL;
        //This method will have the credentials validation
        $this->username = $this->input->post('usermail', TRUE);
        
        $this->form_validation->set_rules('usermail', 'Usermail', 'trim|required|xss_clean|callback_checkUser');

        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $this->fuel->pages->render('password-reset', array('layout' => 'password-reset'));
        } else {
            //Create an MD5 Hash key
            $options = [
                'cost' => 11,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
            $key = password_hash($this->username, PASSWORD_BCRYPT, $options);
            //insert key into DB
            $this->user_model->updateResetKey($this->username, $key);
            //Send user an email
            $this->sendMail($this->username, base_url(), $key);
            $pageVars['email'] = $this->username;
            $this->session->set_userdata("passwordreset", "1");
            $this->fuel->pages->render('password-sent', array('layout' => 'password-sent', 'pageVars' => $pageVars));
        }
    }

    /**
     * Created by Stephen Cotton
     * Date 12/11/15
     */
    function checkKey() {
        if (empty($this->input->get())) {
            redirect("/", "refresh");
        }
        $email = base64_decode($this->input->get('email', true));
        $this->username = $email;
        $this->passkey = $this->input->get('key', true);
        //query the database
        //Check user is allowed to change password (is active)
        if (!$this->checkUser($this->username)) {
            redirect("/", "refresh");
            $this->form_validation->set_message('checkUser', 'Invalid User/Email');
        }
        $pageVars['email'] = $this->username;
        //Show the update form 
        $this->fuel->pages->render('password-update', array('layout' => 'password-update', 'pageVars' => $pageVars));
    }

    /**
     * Created by Stephen Cotton
     * Date 12/11/15
     * @param string $usermail
     * @return boolean
     */
    function checkUser($usermail) {
        $result = $this->user_model->checkUser($this->username);
        if ($result) {
            return true;
        } else {
            $this->form_validation->set_message('checkUser', 'Invalid email/Inactive User');
            return false;
        }
    }
    
    /**
     * Created by Stephen Cotton
     * Date 12/11/15
     */
    function updatePassword(){
        ($this->session->userdata("passwordupdated") === "1") ? redirect("/") : NULL;
        $this->password = $this->input->post("password", true);
        $this->username = $this->input->post("usermail", true);
        
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'trim|required|xss_clean|callback_checkUpdatePassword');

        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $pageVars['email'] = $this->username;
            $this->fuel->pages->render('password-update', array('layout' => 'password-update', 'pageVars' => $pageVars));
        } else {
            //All good so update password
            $this->user_model->updatePassword($this->username, $this->password);
            $pageVars['email'] = $this->username;
            $this->session->set_userdata("passwordupdated", "1");
            $this->fuel->pages->render('password-updated', array('layout' => 'password-updated', 'pageVars' => $pageVars));
        }
    }
    /**
     * Created by Stephen Cotton
     * Date 12/11/15
     * @param string $confirmPassword
     * @return boolean
     */
    function checkUpdatePassword($confirmPassword){
        $bool = ($this->password === $confirmPassword) ? true:false ;
        if ($bool) {
            return true;
        } else {
            $this->form_validation->set_message('checkUpdatePassword', 'Passwords do not match');
            return false;
        }
    }

    /**
     * Created by Stephen Cotton
     * Date 12/11/15
     * @param string $emailAddr
     * @param url $server
     * @param MD5 $key
     */
    private function sendMail($emailAddr, $server, $key) {
        $this->email->from('no-reply@stationaryplus.co.uk', 'StationaryPlus');
        $this->email->to($emailAddr);
        //$ex = explode("@", $emailAddr);
        $usr = base64_encode($emailAddr);
//        $email = base64_decode($usr) . "@googlemail.com";

        $this->email->to($emailAddr);
        $msg = 'Reset Password Link: <a href="' . $server . 'password/check/?email=' . $usr . '&key=' . $key . '">' . $server . 'password/check/?email=' . $usr . '&key=' . $key . '</a>';

        $this->email->subject('Password reset');
        $this->email->message($msg);
        $this->email->send();
//        echo $this->email->print_debugger();
    }

}
