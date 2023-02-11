<?php

namespace Adrashyawarrior\LaravelMultiMailer;

use Exception;
use SendGrid\Mail\Mail;
use SendGrid;

class SendgridMailer
{
    protected $fromEmail = null;
    protected $fromName = null;
    protected $subject = null;
    protected $text = null;
    protected $to = [];

    public function from($fromEmail, $fromName = null)
    {
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
        return $this;
    }

    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function text($text)
    {
        $this->text = $text;
        return $this;
    }

    public function send()
    {
        if (!config('multi-mailer.SENDGRID_API_KEY')) {
            return [
                'success' => false,
                'mailer' => 'sendgrid',
                'message' => 'SENDGRID_API_KEY is not set.',
                'details' => 'NA'
            ];
        }

        $email = new Mail();
        $email->setFrom($this->fromEmail, $this->fromName);
        $email->setSubject($this->subject);
        foreach($this->to as $to){
            $email->addTo($to);
        }
        $email->addContent("text/plain", $this->text);
        // $email->addContent(
        //     "text/html",
        //     "<strong>and easy to do anywhere, even with PHP</strong>"
        // );
        $sendgrid = new SendGrid(config('multi-mailer.SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            // print $response->statusCode() . "\n";
            // print_r($response->headers());
            // print $response->body() . "\n";
            return [
                'success' => true,
                'mailer' => 'sendgrid',
                'message' => 'Email sent successfully.',
                'details' => $response
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'mailer' => 'sendgrid',
                'message' => 'Email failed sending through sendgrid.',
                'details' => $e->getMessage()
            ];
        }
    }
}
