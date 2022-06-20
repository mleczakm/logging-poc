<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

//if ($_SERVER['APP_DEBUG']) {
//    umask(0000);
//
//    Debug::enable();
//}

$_SERVER['APP_RUNTIME_OPTIONS'] = [
    'host' => '0.0.0.0',
    'port' => 8080,
    //    'mode' => SWOOLE_BASE,
    //    'settings' => [
    //        \Swoole\Constant::OPTION_WORKER_NUM => swoole_cpu_num() * 2,
    //        \Swoole\Constant::OPTION_ENABLE_STATIC_HANDLER => true,
    //        \Swoole\Constant::OPTION_DOCUMENT_ROOT => dirname(__DIR__).'/public'
    //    ],
];

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
