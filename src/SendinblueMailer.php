<?php

namespace Adrashyawarrior\LaravelMultiMailer;

use Exception;
use GuzzleHttp\Client;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Api\TransactionalEmailsApi;

class SendinblueMailer
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
        if(!config('multi-mailer.SENDINBLUE_API_KEY')){
            return [
                'success' => false,
                'mailer' => 'sendinblue',
                'message' => 'SENDINBLUE_API_KEY is not set.',
                'details' => 'NA'
            ];
        }

        $from = ['email' => $this->fromEmail];
        if ($this->fromName) $from['name'] = $this->fromName;

        $to = [];
        foreach ($this->to as $email) {
            $to[] = ['email' => $email];
        }

        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', config('multi-mailer.SENDINBLUE_API_KEY'));
        $apiInstance = new TransactionalEmailsApi(new Client(), $config);
        $sendSmtpEmail = new SendSmtpEmail([
            'subject' => $this->subject,
            'sender' => $from,
            'to' => $to,
            'textContent' => $this->text
        ]);

        try {
            $response = $apiInstance->sendTransacEmail($sendSmtpEmail);
            return [
                'success' => true,
                'mailer' => 'sendinblue',
                'message' => 'Email sent successfully.',
                'details' => $response
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'mailer' => 'sendinblue',
                'message' => 'Email failed sending through sendinblue.',
                'details' => $e->getMessage()
            ];
        }
    }
}
