<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  Page created by Stephen Cotton
 *  
 * 
 */

class Login extends CI_Controller {

    private $username;

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    function index() {
        $this->resetLogin();
        $this->fuel->pages->render('login', array('layout' => 'login'));
    }

    function resetLogin() {
        //Unset a few sessions
        $this->session->unset_userdata("passwordreset");
        $this->session->unset_userdata("passwordupdated");
        $this->session->unset_userdata("logged_in");
        $this->session->unset_userdata("model");
        $this->session->unset_userdata("model_year");
        $this->session->unset_userdata("search");
        $this->session->unset_userdata("sort");
    }

    public function validate() {
        //Retrieve post info
        $this->username = $this->input->post('usermail');
        //This method will have the credentials validation
        $this->form_validation->set_rules('usermail', 'Usermail', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $this->fuel->pages->render('login', array('layout' => 'login'));
        } else {
            //Go to private area
            redirect("/categories", "refresh");
        }
    }

    function check_database($password) {
        //query the database
        $result = $this->user_model->login($this->username, $password);
        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'id' => $row->id,
                    'username' => $row->username
                );
                $this->session->set_userdata('logged_in', $sess_array);
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

}
