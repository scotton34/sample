<?php

/* 
 *  Author Stephen Cotton stephen.cotton@stoneacre.co.uk
 *  Created on 
 */

Class Home extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        echo "welcome";
    }
}