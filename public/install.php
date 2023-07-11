<?php

ini_set('display_errors', 'On');
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/topthink/framework/src/helper.php';

const DS = DIRECTORY_SEPARATOR;
const ROOT_PATH = __DIR__ . DS . '..' . DS;
const INSTALL_PATH = ROOT_PATH . 'config' . DS . 'install' . DS;
const CONFIG_PATH = ROOT_PATH . 'config' . DS;

$currentHost = ($_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/';

/**
 * 判断 文件/文件夹 读写权限
 * @param $file
 * @return bool
 */
function isReadWrite($file)
{
    if (DIRECTORY_SEPARATOR == '\\') {
        return true;
    }
    if (DIRECTORY_SEPARATOR == '/' && @ ini_get("safe_mode") === false) {
        return is_writable($file);
    }
    if (!is_file($file) || ($fp = @fopen($file, "r+")) === false) {
        return false;
    }

    fclose($fp);
    return true;
}

/**
 * 判断php版本
 * @param $version
 * @return bool
 */
function checkPhpVersion($version)
{
    $php_version = explode('-', phpversion());
    $check = strnatcasecmp($php_version[0], $version) >= 0 ? true : false;
    return $check;
}

$errorInfo = null;
if (is_file(INSTALL_PATH . 'lock' . DS . 'install.lock')) {
    $errorInfo = '已安装系统，如需重新安装请删除文件：/config/install/lock/install.lock';
} elseif (!isReadWrite(ROOT_PATH . 'config' . DS)) {
    $errorInfo = ROOT_PATH . 'config' . DS . '：读写权限不足';
} elseif (!isReadWrite(ROOT_PATH . 'runtime' . DS)) {
    $errorInfo = ROOT_PATH . 'runtime' . DS . '：读写权限不足';
} elseif (!isReadWrite(ROOT_PATH . 'public' . DS)) {
    $errorInfo = ROOT_PATH . 'public' . DS . '：读写权限不足';
} elseif (!checkPhpVersion('7.2.0')) {
    $errorInfo = 'PHP版本不能小于7.2.0';
} elseif (!extension_loaded("PDO")) {
    $errorInfo = '当前未开启PDO，无法进行安装';
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>安装Api-Admin后台程序</title>
    <link rel="stylesheet" href="static/plugs/layui-v2.5.6/css/layui.css?v=<?php echo time() ?>" media="all">
    <link rel="stylesheet" href="static/common/css/insatll.css?v=<?php echo time() ?>" media="all">
</head>
<body>
<h2>安装Api-Admin后台程序</h2>




</body>
</html>









