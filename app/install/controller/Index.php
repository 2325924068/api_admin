<?php

namespace app\install\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {

        if($this->isAjax){
            $data = $this->post;





        }



        return View::fetch();
    }
}