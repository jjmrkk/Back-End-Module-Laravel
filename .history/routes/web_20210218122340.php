<?php
use Illuminate\Support\Facades\Mail;
use App\Mail\ProvisionRequestMail;

Route::get('/', function () {
    //$userAccess = DB::table('user_access')->where('user_id', 1)->select('description->provision_request->approval_module as approval_module')->first();
    //$access = $userAccess->approval_module->access
    //return gettype(json_decode($userAccess->approval_module));
    //return gettype(json_decode($userAccess->access));
    //$approvalModule = json_decode($userAccess->approval_module);
    //return $approvalModule->access;
    //$data = [
    //    'title' => 'PRS: #',
    //    'sender_name' => '',
    //    'recipient_name' => '',
    //    'recipient_email' => 'johnpaulustaris@gmail.com',
    //    'prs_no' => '#',
    //    'message' => 'test',
    //];
    //Mail::to($data['recipient_email'])->send(new ProvisionRequestMail($data));
})->name('welcome');
//Auth::routes(['register' => false]);
//Route::get('/home', 'HomeController@index')->name('home');
