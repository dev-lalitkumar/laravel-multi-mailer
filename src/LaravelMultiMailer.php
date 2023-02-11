<?php

namespace Adrashyawarrior\LaravelMultiMailer;

use Illuminate\Support\Facades\Log;

class LaravelMultiMailer
{
    protected $mailgun;
    protected $sendinblue;
    protected $sendgrid;

    public function __construct()
    {
        $this->mailgun = new MailgunMailer();
        $this->sendinblue = new SendinblueMailer();
        $this->sendgrid = new SendgridMailer();
    }

    public function from($fromEmail, $fromName = null)
    {
        $this->mailgun->from($fromEmail, $fromName);
        $this->sendinblue->from($fromEmail, $fromName);
        $this->sendgrid->from($fromEmail, $fromName);
        return $this;
    }

    public function to($to)
    {
        $this->mailgun->to($to);
        $this->sendinblue->to($to);
        $this->sendgrid->to($to);
        return $this;
    }

    public function cc($cc)
    {
        $this->mailgun->cc($cc);
        $this->sendinblue->cc($cc);
        $this->sendgrid->cc($cc);
        return $this;
    }

    public function bcc($bcc)
    {
        $this->mailgun->bcc($bcc);
        $this->sendinblue->bcc($bcc);
        $this->sendgrid->bcc($bcc);
        return $this;
    }

    public function subject($subject)
    {
        $this->mailgun->subject($subject);
        $this->sendinblue->subject($subject);
        $this->sendgrid->subject($subject);
        return $this;
    }

    public function text($text)
    {
        $this->mailgun->text($text);
        $this->sendinblue->text($text);
        $this->sendgrid->text($text);
        return $this;
    }

    public function html($html)
    {
        $this->mailgun->html($html);
        $this->sendinblue->html($html);
        $this->sendgrid->html($html);
        return $this;
    }

    public function send()
    {
        $mailers = config('multi-mailer.MAILERS');
        if (!$mailers || !is_array($mailers)) {
            return [
                'success' => false,
                'mailer' => 'NA',
                'message' => 'MAILERS is not set.',
                'details' => 'NA'
            ];
        }
        $response = null;
        foreach ($mailers as $mailer) {
            switch ($mailer) {
                case 'mailgun':
                    $response = $this->mailgun->send();
                    break;
                case 'sendinblue':
                    $response = $this->sendinblue->send();
                    break;
                case 'sendgrid':
                    $response = $this->sendgrid->send();
                    break;
            }
            if (!$response) {
                return [
                    'success' => false,
                    'mailer' => $mailer,
                    'message' => 'No Response.',
                    'details' => 'NA'
                ];
            }
            if ($response['success']) {
                return $response;
            } else {
                Log::info($response);
            }
        }
        return [
            'success' => false,
            'mailer' => 'NA',
            'message' => 'Email failed sending through all mailers.',
            'details' => 'NA'
        ];
    }
}
