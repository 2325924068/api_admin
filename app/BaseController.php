<?php
declare (strict_types=1);

namespace app;

use DateTime;
use think\App;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Response;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var App
     */
    protected $app;
    protected $get;
    protected $post;
    protected $isAjax;
    protected $isPost;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param App $app 应用对象
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {
        $this->get = $this->request->get();
        $this->post = $this->request->post();
        $this->isAjax = $this->request->isAjax();
        $this->isPost = $this->request->isPost();

    }

    /**
     * 验证数据
     * @access protected
     * @param array $data 数据
     * @param string|array $validate 验证器名或者验证规则数组
     * @param array $message 提示信息
     * @param bool $batch 是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

    /**
     * 返回API
     * @access protected
     * @param $message 提示信息
     * @param $code 状态码
     * @param $data 对应数据
     * @param $extend 扩展字段
     * @param $header HTTP头信息
     * @return void
     * @throws HttpResponseException
     */
    protected function returnApi($message = '', $code = 200, $data = [], $extend = [], $header = [])
    {

        $new = new DateTime();

        $return = [
            'code' => $code,
            'message' => $message,
            'time' => $new->format('Y-m-d H:i:s'),
        ];

        if (!empty($data)) {
            $return['data'] = $data;
        }

        if (!empty($extend)) {
            foreach ($extend as $key => $value) {
                $return[$key] = $value;
            }
        }

        $response = Response::create($return, 'json')->header($header);
        throw new HttpResponseException($response);
    }

}
