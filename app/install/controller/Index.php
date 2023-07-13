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

            @touch('./install.lock');
            $this->returnApi('安装成功',200,$data);
        }

        return View::fetch();
    }
}