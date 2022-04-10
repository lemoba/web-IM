<?php declare(strict_types=1);

use App\Controller\AuthController;
use App\Controller\CheckHealthController;
use App\Controller\Common\CommonController;
use App\Controller\UserController;
use App\Middleware\AuthMiddleware;
use Webman\Route;


Route::group('/api/v1/', function () {
    Route::get('check-health', [CheckHealthController::class, 'check_health']);    // 健康检查

    //公共模块
    Route::post('common/sms-code', [CommonController::class, 'sendSmsCode']);      // 发送短信验证码

    //Auth模块
    Route::group('auth/', function () {
        Route::post('register', [AuthController::class, 'register']);              // 注册
        Route::post('login', [AuthController::class, 'login']);                    // 登录
        Route::post('forget', [AuthController::class, 'forget']);                  // 忘记密码
        Route::post('logout', [AuthController::class, 'logout']);                  // 退出登录
        Route::post('refresh-token', [AuthController::class, 'refreshToken']);     // 刷新token
    });

    // setting模块
    Route::group('users/', function () {
        Route::get('setting', [UserController::class, 'setting']);                  // 用户设置
        Route::get('detail', [UserController::class, 'detail']);                    // 用户详情
    })->middleware([AuthMiddleware::class]);
});

Route::get('/test', function () {
    echo date("Y-m-d",strtotime("+1 day"));
    return json('Y');
});

Route::fallback(function(){
    return json(['code' => 404, 'msg' => '404 not found']);
});

Route::options('[{path:.+}]', function (){
    return response('');
});