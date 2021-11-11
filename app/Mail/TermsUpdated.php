<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TermsUpdated extends Mailable
{
    use Queueable, SerializesModels;

    const SUBJECT = "We've updated our terms";
    const ADDRESS = 'contdevpn@protonmail.com';
    const SENDER_NAME = 'Laravel Lynx';
    const BCC_ADDRESS = 'contdevpn@protonmail.com';



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.terms_updated')
            ->with([
                'url' => route('terms')
            ])
            ->from(self::ADDRESS, self::SENDER_NAME)
            ->subject(self::SUBJECT)
            ->bcc(self::BCC_ADDRESS);
    }
}
