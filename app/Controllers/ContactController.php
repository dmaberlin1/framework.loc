<?php

namespace App\Controllers;

use App\Models\Contact;
use PHPFramework\Controller;
use PHPFramework\View;


class ContactController extends BaseController
{


    public function index()
    {


        $title = 'Contact page';
        $name = 'Connor';
        return view('Contact/contact', ['title' => $title, 'name' => $name]);
        //        return view('Contact/contact',compact('title','name'));

    }

    public function send()
    {
        $model = new Contact();
        $model->loadData();

        $thumbnail = 'thumbnail';
        if (isset($_FILES[$thumbnail])) {
            $model->attributes[$thumbnail] = $_FILES[$thumbnail];
        } else {
            $model->attributes[$thumbnail] = [];
        }



        if (!$model->validate()) {
            //         dump($model->getErrors());
            return view('Contact/contact', ['title' => 'contact form', 'errors' => $model->getErrors()]);
        }

        $files=[];
        if($model->attributes[$thumbnail]['error']===0){
            $files[]=upload_file($model->attributes[$thumbnail],path:true);
        }

        $content=nl2br($model->attributes['content']);
        $body = "
        <b>Name:</b> {$model->attributes['name']}<br>
        <b>Email:</b> {$model->attributes['email']}<br>
        <b>content:</b> {$content}
                ";
        $addAddress = [EMAIL['add_address']];
        $subject='Mail from site';
        $this->sendEmailAndGetFlashMessage($addAddress,$body,$subject, $files);
        //        response()->redirect('/');
        response()->redirect('/framework.loc/contact');
    }

    /**
     * @param array $files
     * @return void
     */
    public function unlinkAfterSendEmail(array $files): void
    {
        if ($files) {
            foreach ($files as $file) {
                unlink($file);
            }
        }
    }

    /**
     * @param string $body
     * @param array $files
     * @return void
     */
    public function sendEmailAndGetFlashMessage(array $add_address,string $body,$subject, array $files): void
    {
        if (send_mail($add_address, $subject, $body, $files)) {
            session()->setFlash('success', 'Mail is send');
            $this->unlinkAfterSendEmail($files);
        } else {
            session()->setFlash('error', 'MailSendError');
        }
    }

}