<?php

namespace App\Service;

use \PHPMailer;
use App\Service\Logger;

class Mailer
{
    const TEMPLATE = 'views/email.html';

    private $mailer;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
        $this->mailer->isHTML(true);
        $this->mailer->Body = file_get_contents(__DIR__ . '/../../' . self::TEMPLATE);
    }

    public function to($email)
    {
        $this->mailer->addAddress($email);

        return $this;
    }

    public function addCC($email)
    {
        $this->mailer->addCC($email);

        return $this;
    }

    public function addBCC($email)
    {
        $this->mailer->addBCC($email);
        
        return $this;
    }

    public function from($email, $name)
    {
        $this->mailer->setFrom($email, $name);

        return $this;
    }

    public function replyTo($email, $name)
    {
        $this->mailer->addReplyTo($email, $name);

        return $this;
    }

    public function attachment($file, $name = false)
    {
        if($name !== false) {
            $this->mailer->addAttachment($file, $name);
        } else {
            $this->mailer->addAttachment($file);
        }

        return $this;
    }

    public function subject($subject)
    {
        $this->mailer->Subject = $subject;

        return $this;
    }

    public function message($content)
    {
        $this->mailer->Body = str_replace('%message%', $content, $this->mailer->Body);

        return $this;
    }

    public function heading($heading)
    {
        $this->mailer->Body = str_replace('%heading%', $content, $this->mailer->Body);

        return $this;
    }

    public function send()
    {
        if(!$this->mailer->send()) {
            Logger::send($this->mailer->ErrorInfo);
            return false;
        }

        return true;
    }
}
