<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Notification\Constants\EmailTypes;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $UserRepository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->UserRepository = $repository;
    }

    public function showFormEmail()
    {
        $users = $this->getUsers();
        $email_types = EmailTypes::toString();
        return view('admin.notifications.email.create', compact('users', 'email_types'));
    }

    public function sendEmail(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'exists:users,id',
                'type' => 'integer'
            ]);
            $emailType = EmailTypes::toMail($request->type);
            $user = $this->UserRepository->find($request->user_id);
            SendEmail::dispatch($user, new  $emailType);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception  $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 422);
        }
    }

    public function showFormSms()
    {
        return view('admin.notifications.sms.create', ['users' => $this->getUsers()]);
    }

    public function sendSms(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'exists:users,id',
                'text' => 'string'
            ]);
            /*todo Add Service*/
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * @return mixed
     */
    private function getUsers()
    {
        return $this->UserRepository->all();
    }
}
