<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Userplan;
use Cart;
use App\Models\AbandonedCart;
use App\Useroption;
use App\Mail\BulkEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AbandonedCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Useroption::where('user_id', seller_id())->where('key','abandoned_cart_days')->first();
        $days = $data ? intval($data->value) : 1;
        $days = 0;
        $carts = AbandonedCart::where('user_id', seller_id())->whereDate('updated_at', '<=', Carbon::now()->subDays($days))->get();
        return view('seller.abandoned_cart.index', compact('carts'));
    }
    
    public function send_email(Request $request)
    {
        foreach($request->emails as $email) {
            $data['description'] = 'Abandoned Cart Reminder';
            $data['subject']= 'Abandoned Cart Reminder';
            $data['to_subscriber'] = $email;
            $data['mail_from'] = env('MAIL_TO');
            if(env('QUEUE_MAIL') == 'on'){
                Mail::to($email)->send(new BulkEmail($data));
            }
            else{
                Mail::to($email)->send(new BulkEmail($data));
            }
        }
    
        return response()->json(['Mail Sent Successfully']);
    }
}