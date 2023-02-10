<?php

namespace Adrashyawarrior\LaravelMultiMailer;

class LaravelMultiMailer
{
    protected $mailgun;
    protected $sendinblue;

    public function __construct()
    {
        $this->mailgun = new MailgunMailer();
        $this->sendinblue = new SendinblueMailer();
    }

    public function from($fromEmail, $fromName = null)
    {
        $this->mailgun->from($fromEmail, $fromName);
        $this->sendinblue->from($fromEmail, $fromName);
        return $this;
    }

    public function to($to)
    {
        $this->mailgun->to($to);
        $this->sendinblue->to($to);
        return $this;
    }

    public function subject($subject)
    {
        $this->mailgun->subject($subject);
        $this->sendinblue->subject($subject);
        return $this;
    }

    public function text($text)
    {
        $this->mailgun->text($text);
        $this->sendinblue->text($text);
        return $this;
    }

    public function send()
    {
        $mailers = config('multi-mailer.MAILERS');
        if(!$mailers || !is_array($mailers)){
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
            }
            if ($response && $response['success']) {
                return $this->mailgun->send();
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
