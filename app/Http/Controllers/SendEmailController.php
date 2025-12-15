<?php

namespace App\Http\Controllers;

use App\Mail\SendingEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function index() {
        Mail::to('aditjelek@gmail.com')->send(new SendingEmail());
    }
}
