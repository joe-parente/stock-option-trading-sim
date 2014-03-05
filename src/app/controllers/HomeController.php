<?php

class HomeController extends BaseController {

    protected $layout = "layouts.main";

    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getDashboard')));
    }

    public function getIndex() {
        
        $this->layout->with('header', '');
        $this->layout->content = View::make('home');
    }

}