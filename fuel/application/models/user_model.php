<?php

/*
 *  Page created by Stephen Cotton
 *  
 * 
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once(FUEL_PATH . 'models/base_module_model.php');

class User_model extends Base_module_model {

    public function __construct() {
        parent::__construct('user_model');
    }

    function form_fields($values = array(), $related = array()) {
        $fields = parent::form_fields($values, $related);

        // ******************* ADD CUSTOM FORM STUFF HERE *******************


        return $fields;
    }

    /**
     * Created by Stephen Cotton
     * Date 12/11/15
     * @param string $username
     * @param MD5 $password
     * @return boolean
     */
    function login($username, $password) {
        $this->db->select('id, username, password');
        $this->db->from('users');
        $this->db->where('username', $username);
        $this->db->where('password', MD5($password));
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    /**
     * Created by Stephen Cotton
     * Date 12/11/15
     * @param string $username
     * @return boolean
     */
    function checkUser($username){
        $query = $this->db->get_where("users", array("username"=>$username, "active"=>"Yes"));
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    /**
     * Created by Stephen Cotton
     * Date 12/11/15
     * @param string $user
     * @param MD5 $key
     * $return null
     */
    function updateResetKey($user, $key){
        $date = date("Y-m-d H:m:i");
        $this->db->where('username', $user);
        $this->db->update("users", array("resetkey"=>$key, "resetkey_created"=>$date));
    }
    
    function updatePassword($user,$pass){
        $this->db->where(array('username'=>$user, "active"=>"Yes"));
        $this->db->update("users", array("password"=>  md5($pass), "resetkey"=>null));
    }
    

}

class User_model_record extends Base_module_record {
    
}
