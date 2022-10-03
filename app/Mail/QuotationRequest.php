<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mailRequest1;

    public function __construct($request)
    {
        $this->mailRequest1 = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('midhun.v@tranetech.ae')
                ->subject('Quotation Request')
                ->view('EmailTemplate')
               
                 ->attach($this->mailRequest1->attachment,
                 [
                    'as' => 'attachment_name.pdf',
                     'mime' => 'application/pdf',
                 ])
                ;


       
    }
}
