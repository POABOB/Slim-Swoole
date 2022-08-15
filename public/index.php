#!/usr/local/bin/php
<?php

declare(strict_types=1);

use Imefisto\PsrSwoole\ServerRequest as PsrRequest;
use Imefisto\PsrSwoole\ResponseMerger;
use Swoole\Http\Request;
use Swoole\Http\Response;
use App\Utils\PDOPool;

// require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . "/../config/bootstrap.php";

$http = new swoole_http_server("0.0.0.0", 9501);
$uriFactory = new Slim\Psr7\Factory\UriFactory;
$streamFactory = new Slim\Psr7\Factory\StreamFactory;
$responseFactory = new Slim\Psr7\Factory\ResponseFactory;
$uploadedFileFactory = new Slim\Psr7\Factory\UploadedFileFactory;
$responseMerger = new ResponseMerger;

$http->set([
    // 靜態
    'document_root' => __DIR__ . '/', // v4.4.0以下，必須為絕對路徑
    'enable_static_handler' => true,
    // 設定worker，數量為cpu數量的1~4倍
    'worker_num' => 1,
    // 每個woker最大任務數，避免記憶體溢出導致系統崩潰
    'max_request' => 5000,
    // TCP的最大連接數
    'max_conn' => 100000,
    // 發包策略
    // 1 => 輪巡模式 
    // 2 => 固定模式，根據連線檔案分配符合worker。保證同一連線由同一worker處理
    // 3 => 搶占模式，根據worker閒忙狀態選擇閒置的worker
    'dispatch_mode' => 2,
    // 
    'debug_mode'=> 1,
    // 守護進程
    // 'daemonize' => false,
    // 'log_file'=> '/var/log/swoole.log',
]);

$http->on(
    'request',
    function (
        Request $swooleRequest,
        Response $swooleResponse
    ) use (
        $uriFactory,
        $streamFactory,
        $uploadedFileFactory,
        $responseFactory,
        $responseMerger,
        $app
    ) {
        /**
         * create psr request from swoole request
         */
        $psrRequest = new PsrRequest(
            $swooleRequest,
            $uriFactory,
            $streamFactory,
            $uploadedFileFactory
        );

        /**
         * process request (here is where slim handles the request)
         */
        $psrResponse = $app->handle($psrRequest);

        /**
         * merge your psr response with swoole response
         */
        $responseMerger->toSwoole(
            $psrResponse,
            $swooleResponse
        )->end();
    }
);

$http->start();