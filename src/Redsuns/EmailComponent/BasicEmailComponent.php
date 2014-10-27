<?php

namespace Redsuns\EmailComponent;

use PHPMailer;

class BasicEmailComponent
{
    /**
     *
     * @var array
     */
    private $config;
    
    /**
     *
     * @var PHPMailer
     */
    private $mail;
    
    /**
     * @param array $config
     */
    public function __construct($config = array())
    {
        $this->config = $config;
        $this->mail = new PHPMailer();
        
        $this->__applyConfigurations();
    }
    
    /**
     * @param array $to
     */
    public function setTo(array $to)
    {
        $this->mail->addAddress($to['email'], $to['name']);
        return $this;
    }
    
    /**
     * @param array $from
     * @return \Redsuns\EmailComponent\BasicEmailComponent
     */
    public function setFrom(array $from)
    {
        $this->mail->From = $from['email'];
        $this->mail->FromName = $from['name'];
        return $this;
    }
    
    public function setSubject($subject)
    {
        $this->mail->Subject = $subject;
        return $this;
    }
    
    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->mail->Body = $content;
        $this->mail->AltBody = $content;
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function send()
    {
        $emailSent = $this->mail->send();
        $this->mail->clearAllRecipients();
        return $emailSent;
    }
    
    /**
     * 
     */
    private function __applyConfigurations()
    {
        if (isset($this->config['is_smtp']) && true === $this->config['is_smtp']) {
            $this->mail->isSMTP();

            $this->mail->Host = $this->config['smtp_host'];
            $this->mail->Port = $this->config['smtp_port'];
            $this->mail->SMTPAuth = $this->config['smtp_auth'];
            $this->mail->Username = $this->config['smtp_username'];
            $this->mail->Password = $this->config['smtp_password'];
            $this->mail->SMTPSecure = $this->config['smtp_secure'];
        }

        $this->mail->CharSet = isset($this->config['charset']) ? $this->config['charset'] : 'utf-8';
        $this->mail->WordWrap = isset($this->config['word_wrap']) ? $this->config['word_wrap'] : 150;
        
        if( isset($this->config['is_html']) && true === $this->config['is_html']) {
            $this->mail->isHTML(true);
        }
    }

}
