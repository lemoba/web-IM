<?php declare(strict_types=1);

namespace App\Service\Contact;

use App\Model\ContactApply;
use App\Service\UserService;

class ContactApplyService
{
    /**
     * @Inject()
     * @var UserService
     */
    protected $userService;

    public function friendApply(int $friend_id, string $remark)
    {
        $user_id = $this->userService->uid();

        $message = ContactApply::query()->where([
            'user_id' => $user_id,
            'friend_id' =>$friend_id
        ])->orderByDesc('id')->first();

        if (is_null($message)) {
            ContactApply::create([
                'user_id' => $user_id,
                'friend_id' =>$friend_id,
                'remark' => $remark,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $message->remark = $remark;
            $message->created_at = date('Y-m-d H:i:s');
            $message->save();
        }
    }
}