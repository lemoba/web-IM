<?php declare(strict_types=1);

use App\controller\CheckHealthController;
use App\controller\Common\CommonController;
use Webman\Route;


Route::group('/api/v1', function () {
    Route::get('/check-health', [CheckHealthController::class, 'check_health']); // 健康检查
    Route::post('/common/sms-code', [CommonController::class, 'sendSmsCode']);  // 发送短信验证码
});

Route::fallback(function(){
    return json(['code' => 404, 'msg' => '404 not found']);
});

Route::options('[{path:.+}]', function (){
    return response('');
});