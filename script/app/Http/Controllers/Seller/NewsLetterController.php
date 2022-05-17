<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\NewsLetter;
use App\Models\User;
use App\Models\Userplan;
use App\Models\Customer;
use App\Http\Requests;
use App\Mail\BulkEmail;
use App\Plan;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class NewsLetterController extends Controller
{
   
    public function NewsLetter()
    {
      return view('seller.marketing.newsletter');
    }
    public function store_NewsLetter(Request $request)
    {
          $request->validate([
                  'title' => 'required|max:255',
                  'description' => 'required',
            ]);
            
            $newsletter = new NewsLetter;
            $newsletter->title = $request->title;
            $newsletter->description = $request->description;
            $newsletter->user_id = seller_id();
            $newsletter->save();
             return response()->json(['NewsLetter Created']);
        
    }
    
    public function edit_newsletter($id)
    {
         $newsletter = NewsLetter::find($id);
         return view('seller.marketing.newsletter.edit', compact('newsletter'));
        
    }
      public function update_NewsLetter(Request $request, $id)
    {
          $request->validate([
                  'title' => 'required|max:255',
                  'description' => 'required',
            ]);
            
            $newsletter = NewsLetter::find($id);
            $newsletter->title = $request->title;
            $newsletter->description = $request->description;
            $newsletter->user_id = seller_id();
            $newsletter->update();
            return response()->json(['NewsLetter Updated']);
        
    }
    
    public function delete_newsletter($id)
    {
        $newsletter = Newsletter::find($id);
        $newsletter->delete($id);
        return back()->with('message', 'NewsLetter Deleted');
        
    }
    
    public function all_users()
    {
        $users = Customer::where('created_by', seller_id())->orderBy('name')->get();
        $templates = Newsletter::where('user_id', seller_id())->orderBy('title')->get();
        return view('seller.marketing.newsletter.user',compact('users','templates'));
    }
    
    public function send_email(Request $request)
    {
        $p = Userplan::where('user_id', seller_id())->latest()->first();
        $blog_plan = json_decode($p->plan->data);
        $validatedData = $request->validate([
            'template_id' => 'required|integer',
            'subject' => 'required|string',
            'emails' => 'required|array|min:1',
        ]);
        foreach($request->emails as $email){
            if($blog_plan->total_emails > 0){
                
                $data['description']= Newsletter::where('id',$request->template_id)->pluck('description')->first();
                $data['subject']=$request->subject;
                $data['to_subscriber'] = $email;
                $data['mail_from'] = env('MAIL_TO');
                if(env('QUEUE_MAIL') == 'on'){
                    Mail::to($email)->send(new BulkEmail($data));
                //   dispatch(new \App\Jobs\SendInvoiceEmail($data));
                }
                else{
                    Mail::to($email)->send(new BulkEmail($data));
                }
                
                $plan_data['product_limit']=$blog_plan->product_limit;
                $plan_data['customer_limit']=$blog_plan->customer_limit;
                $plan_data['storage']=$blog_plan->storage;
                $plan_data['custom_domain']=$blog_plan->custom_domain;
                $plan_data['inventory']=$blog_plan->inventory;
                $plan_data['pos']=$blog_plan->pos;
                $plan_data['blog']=$blog_plan->blog;
                $plan_data['customer_panel']=$blog_plan->customer_panel;
                $plan_data['pwa']=$blog_plan->pwa;
                $plan_data['whatsapp']=$blog_plan->whatsapp;
                $plan_data['live_support']=$blog_plan->live_support;
                $plan_data['qr_code']=$blog_plan->qr_code;
                $plan_data['facebook_pixel']=$blog_plan->facebook_pixel;
                $plan_data['custom_css']=$blog_plan->custom_css;
                $plan_data['custom_js']=$blog_plan->custom_js;
                $plan_data['gtm']=$blog_plan->gtm;
                $plan_data['location_limit']=$blog_plan->location_limit;
                $plan_data['category_limit']=$blog_plan->category_limit;
                $plan_data['brand_limit']=$blog_plan->brand_limit;
                $plan_data['variation_limit']=$blog_plan->variation_limit;
                $plan_data['google_analytics']=$blog_plan->google_analytics;
                $plan_data['total_emails']=(int)$blog_plan->total_emails -1;
                
                Plan::where('id' , $p->plan->id)->update(['data'=> json_encode($plan_data)]);
            }else{
                return response()->json(['Your Email Limit Finished Contact To Admin Please Or upgrade your Plan.']);
                
            }
            
        }
        return response()->json(['Mail Sent Successfully']);
    }
    
   
}