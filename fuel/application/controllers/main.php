<?php

/* 
 *  Author Stephen Cotton stephen.cotton@stoneacre.co.uk
 *  Created on 
 */

Class Main extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->fuel->pages->render('home', array(
                'layout' => 'main'
            ));
    }
    
}