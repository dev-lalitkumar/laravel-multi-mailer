<?php

namespace Adrashyawarrior\LaravelMultiMailer;

use Exception;
use Mailgun\Mailgun;

class MailgunMailer
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
        if(!config('multi-mailer.MAILGUN_API_KEY')){
            return [
                'success' => false,
                'mailer' => 'mailgun',
                'message' => 'MAILGUN_API_KEY is not set.',
                'details' => 'NA'
            ];
        }

        if(!config('multi-mailer.MAILGUN_HOSTNAME')){
            return [
                'success' => false,
                'mailer' => 'mailgun',
                'message' => 'MAILGUN_HOSTNAME is not set.',
                'details' => 'NA'
            ];
        }

        if(!config('multi-mailer.MAILGUN_DOMAIN')){
            return [
                'success' => false,
                'mailer' => 'mailgun',
                'message' => 'MAILGUN_DOMAIN is not set.',
                'details' => 'NA'
            ];
        }

        $from = $this->fromEmail;
        if ($this->fromName) $from = $this->fromName . ' <' . $this->fromEmail . '>';
        $mgClient = Mailgun::create(config('multi-mailer.MAILGUN_API_KEY'), config('multi-mailer.MAILGUN_HOSTNAME'));
        $domain = config('multi-mailer.MAILGUN_DOMAIN');
        $params = array(
            'from'    => $from,
            'to'      => implode(',', $this->to),
            'subject' => $this->subject,
            'text'    => $this->text
        );

        try {
            # Make the call to the client.
            $response = $mgClient->messages()->send($domain, $params);
            return [
                'success' => true,
                'mailer' => 'mailgun',
                'message' => 'Email sent successfully.',
                'details' => $response
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'mailer' => 'mailgun',
                'message' => 'Email failed sending through mailgun.',
                'details' => $e->getMessage()
            ];
        }
    }
}
