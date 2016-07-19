<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function _before_index(){
		echo 'index.before</br>';
	} 

    public function index(){
       echo 'index</br>';
    }
    	public function _after_index(){
		echo 'index.after</br>';
	} 
}