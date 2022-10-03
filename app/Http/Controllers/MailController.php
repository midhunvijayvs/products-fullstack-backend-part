<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\QuotationRequest;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        Mail::to($request->to)->cc($request->cc)->bcc($request->bcc)->send(new QuotationRequest($request));    
    }
}


