<?php

namespace app\admin\controller;
use app\common\controller\AdminController;

class Login extends AdminController
{

    /**
     * 初始化方法
     * @return void
     */
    public function initialize(){
        parent::initialize();
        $action = $this->request->action();



    }

    /**
     * 用户登录
     * @return void
     */
    public function index(){

    }
}
