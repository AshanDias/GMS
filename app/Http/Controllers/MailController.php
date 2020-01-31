<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
    public function basic_email(Request $request) {
        //{customerEmail: "w.l.n.ishara@gmail.com", customerName: "Test2", vehicleType: "tractor", grpId: "d0"}   
        $emailTo = $request->customerEmail;
        $emailFrom = 'info@garb.tk';
        $name = $request->customerName;
        $vType =  $request->vehicleType; 
        $messageText = "Your Garbage request was approved. Thank you!";  
        $data = array('name'=>$name,'emailTo' => $emailTo,'emailFrom' => $emailFrom,'messageText'=>$messageText);

         try {
            
                Mail::send(['text'=>'mail'], $data , function($message) use ($emailTo,$emailFrom,$name,$messageText){
                $message->to($emailTo,$name)
                ->subject($messageText);                
                $message->from('info@garb.tk','GMS Team Maharagama Urban Council');
            
            });

            return response($data,200);
         } catch (Exception $th) {
             return $th->getMessage();
         }
    }
//    public function html_email() {
//       $data = array('name'=>"Virat Gandhi");
//       Mail::send('mail', $data, function($message) {
//          $message->to('abc@gmail.com', 'Tutorials Point')->subject
//             ('Laravel HTML Testing Mail');
//          $message->from('xyz@gmail.com','Virat Gandhi');
//       });
//       echo "HTML Email Sent. Check your inbox.";
//    }
//    public function attachment_email() {
//       $data = array('name'=>"Virat Gandhi");
//       Mail::send('mail', $data, function($message) {
//          $message->to('abc@gmail.com', 'Tutorials Point')->subject
//             ('Laravel Testing Mail with Attachment');
//          $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
//          $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
//          $message->from('xyz@gmail.com','Virat Gandhi');
//       });
//       echo "Email Sent with attachment. Check your inbox.";
//    }
}