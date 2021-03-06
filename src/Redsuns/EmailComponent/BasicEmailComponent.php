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
        
        $this->applyConfigurations();
    }
    
    /**
     * 
     * @param mixed $to
     * @return \Redsuns\EmailComponent\BasicEmailComponent
     * @throws Exception
     */
    public function setTo($to)
    {
        if( is_array($to) ) {
            if( !array_key_exists('name', $to) || !array_key_exists('email', $to) ) {
                throw new Exception('Você deve fornecer os campos "nome" e "email"');
            }

            $this->mail->addAddress($to['email'], $to['name']);
        } else {
            $this->parseToAsString($to);
        }
        
        return $this;
    }
    
    /**
     * 
     * @param mixed $bcc
     * @return \Redsuns\EmailComponent\BasicEmailComponent
     * @throws Exception
     */
    public function setBcc($bcc)
    {
        if( is_array($bcc) ) {
            if( !array_key_exists('name', $bcc) || !array_key_exists('email', $bcc) ) {
                throw new Exception('Você deve fornecer os campos "nome" e "email"');
            }
            
            $this->mail->addBCC($bcc['email'], $bcc['name']);
        } else {
            $this->mail->addBCC($bcc);
        }
        
        return $this;
    }
    
    /**
     * 
     * @param mixed $from
     * @return \Redsuns\EmailComponent\BasicEmailComponent
     * @throws Exception
     */
    public function setFrom($from)
    {
        if( is_array($from) ) {
            if( !array_key_exists('name', $from) || !array_key_exists('email', $from) ) {
                throw new Exception('Você deve fornecer os campos "nome" e "email"');
            }
            
            $this->mail->From = $from['email'];
            $this->mail->FromName = $from['name'];
        } else {
            $this->mail->From = $from;
        }
        
        return $this;
    }
    
    /**
     * 
     * @param mixed $replyTo
     * @return \Redsuns\EmailComponent\BasicEmailComponent
     * @throws Exception
     */
    public function setReplyTo($replyTo)
    {
        if( is_array($replyTo) ) {
            if( !array_key_exists('name', $replyTo) || !array_key_exists('email', $replyTo) ) {
                throw new Exception('Você deve fornecer os campos "nome" e "email"');
            }
            
            $this->mail->addReplyTo($replyTo['email'], $replyTo['name']);
        } else {
            $this->mail->addReplyTo($replyTo);
        }
        
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
    private function applyConfigurations()
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
    
    /**
     * Realiza o tratamento de e-mails caso o(s) mesmo(s) seja(m) enviados como string
     * 
     * @param string $to
     */
    private function parseToAsString($to)
    {
        if (false !== strpos($to, ',')) {
            $emails = explode(',', $to);
            foreach ($emails as $email) {
                $this->mail->addAddress($email);
            }
        } else {
            $this->mail->addAddress($to);
        }
    }

}
