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
    protected $html = null;
    protected $to = [];
    protected $cc = [];
    protected $bcc = [];


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

    public function cc($cc)
    {
        $this->cc = $cc;
        return $this;
    }

    public function bcc($bcc)
    {
        $this->bcc = $bcc;
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

    public function html($html)
    {
        $this->html = $html;
        return $this;
    }

    public function send()
    {
        if (!config('multi-mailer.SENDINBLUE_API_KEY')) {
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

        $cc = [];
        foreach ($this->cc as $email) {
            $cc[] = ['email' => $email];
        }

        $bcc = [];
        foreach ($this->bcc as $email) {
            $bcc[] = ['email' => $email];
        }

        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', config('multi-mailer.SENDINBLUE_API_KEY'));
        $apiInstance = new TransactionalEmailsApi(new Client(), $config);
        $params = [];
        $params['subject'] = $this->subject;
        $params['sender'] = $from;
        $params['to'] = $to;
        if ($cc) $params['cc'] = $cc;
        if ($bcc) $params['bcc'] = $bcc;
        if ($this->text) $params['textContent'] = $this->text;
        if ($this->html) $params['htmlContent'] = $this->html;
        $sendSmtpEmail = new SendSmtpEmail($params);

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
