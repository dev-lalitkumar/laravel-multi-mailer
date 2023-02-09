<?php

namespace Adrashyawarrior\LaravelMultiMailer;

class LaravelMultiMailer
{
    protected $mailgun;

    public function __construct()
    {
        $this->mailgun = new MailgunMailer();
    }

    public function from($fromEmail, $fromName = null)
    {
        $this->mailgun->from($fromEmail, $fromName);
        return $this;
    }

    public function to($to)
    {
        $this->mailgun->to($to);
        return $this;
    }

    public function subject($subject)
    {
        $this->mailgun->subject($subject);
        return $this;
    }

    public function text($text)
    {
        $this->mailgun->text($text);
        return $this;
    }

    public function send()
    {
        return $this->mailgun->send();
    }
}
