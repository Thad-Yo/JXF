<?php
header('content-type:text');
namespace User\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->show('hello jxf');
    }
}