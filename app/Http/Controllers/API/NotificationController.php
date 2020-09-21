<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
class NotificationController extends Controller
{
    public function notification(){
        $user = User::where('role','admin')->first();
        return response()->json(['notifications' => $user->unreadNotifications->count(),'user_id' => $user->id]);
    }
    public function notifList($user_id){
        $user = User::findOrFail($user_id);
        return $user->notifications;
    }
}
