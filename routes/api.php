<?php declare(strict_types=1);

use App\Controller\AuthController;
use App\Controller\CheckHealthController;
use App\Controller\Common\CommonController;
use App\Controller\Contact\ContactApplyController;
use App\Controller\Contact\ContactController;
use App\Controller\Talk\TalkController;
use App\Controller\Talk\TalkRecordController;
use App\Controller\UserController;
use App\Middleware\AuthMiddleware;
use App\Service\SocketService;
use Tinywan\Jwt\JwtToken;
use Webman\Route;

Route::group('/api/v1', function () {

    // 不需要登录
    Route::group('/', function () {
        Route::get('check-health', [CheckHealthController::class, 'check_health']);     // 健康检查

        //公共模块
        Route::post('common/sms-code', [CommonController::class, 'sendSmsCode']);       // 发送短信验证码

        // 不需要登录
        Route::post('auth/register', [AuthController::class, 'register']);              // 注册
        Route::post('auth/login', [AuthController::class, 'login']);                    // 登录
    });

    // 需要登录
    Route::group('/', function () {
        // auth模块
        Route::post('auth/forget', [AuthController::class, 'forget']);                  // 忘记密码
        Route::post('auth/logout', [AuthController::class, 'logout']);                  // 退出登录
        Route::post('auth/refresh-token', [AuthController::class, 'refreshToken']);     // 刷新token

        // setting模块
        Route::get('users/setting', [UserController::class, 'setting']);                // 用户设置
        Route::get('users/detail', [UserController::class, 'detail']);                  // 用户详情
        Route::post('users/change/detail', [UserController::class, 'edit']);            // 编辑信息

        // upload模块
        Route::post('upload/avatar', [CommonController::class, 'uploadAvatar']);        // 上传头像

        // contact模块
        Route::get('contact/search', [ContactController::class, 'search']);             // 搜索用户
        Route::get('contact/detail', [ContactController::class, 'detail']);             // 搜索详情
        Route::get('contact/list', [ContactController::class, 'list']);                 // 好友列表
        Route::post('contact/apply/create', [ContactApplyController::class, 'create']); // 好友申请
        // Route::post('contact/apply/unread-num', [ContactApplyController::class, 'unreadNum']);   // 未读消息
        // Route::post('contact/apply/records', [ContactApplyController::class, 'records']);        // 未读消息

        Route::post('talk/create', [TalkController::class, 'create']);                          // 创建聊天
        Route::get('talk/talk_list', [TalkController::class, 'talkList']);                      // 聊天列表
        Route::get('talk/record_list/{receiver_id:\d+}', [TalkRecordController::class, 'recordList']);            // 聊天记录列表

    })->middleware([AuthMiddleware::class]);
});

Route::get('/test', function () {
    var_dump(JwtToken::getCurrentId());
});

Route::fallback(function(){
    return json(['code' => 404, 'msg' => '404 not found']);
});

Route::options('[{path:.+}]', function (){
    return response('');
});