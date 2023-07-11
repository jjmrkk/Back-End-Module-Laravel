<?php
use Illuminate\Support\Facades\Mail;
use App\Mail\ProvisionRequestMail;

Route::get('/', function () {
    $conUsBody = '';

        $conUsBody .= '<h2 class="text-center">Hello Admin,</h2>
                        <b><p> '.trim($request->name).' Want some assesment</p></b>
                        <p>Here are the details:</p>
                        <p>Name: '.trim($request->name).'</p>
                        <p>Email: '.trim($request->email).'</p>
                        <p>Subject: '.trim($request->subject).'</p>';

      $contactContent = array('contactusbody' =>  $conUsBody);

      Mail::send(['html' => 'emails.mail'], $contactContent,

      function($message) use ($mailData)
      {
        $message->to('vinay.kaithwas@gmail.com', 'Admin')->subject($mailData['subject']);
        $message->attach($mailData['attachfilepath']);
      });
      return back()->with('success', 'Thanks for contacting us!');
    
});
//Auth::routes(['register' => false]);
//Route::get('/home', 'HomeController@index')->name('home');
