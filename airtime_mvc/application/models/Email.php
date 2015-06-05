<?php

class Application_Model_Email
{
    /**
     * Send email
     *
     * @param  string $subject
     * @param  string $message
     * @param  mixed  $tos
     * @return void
     */
    public static function send($subject, $message, $tos, $from = null)
    {
        $mailServerConfigured = Application_Model_Preferences::GetMailServerConfigured() == true ? true : false;
        $mailServerRequiresAuth = Application_Model_Preferences::GetMailServerRequiresAuth() == true ? true : false;
        $success = true;

        if ($mailServerConfigured) {
            $mailServer = Application_Model_Preferences::GetMailServer();
            $mailServerPort = Application_Model_Preferences::GetMailServerPort();
            if (!empty($mailServerPort)) {
                $port = $mailServerPort;
            }

            if ($mailServerRequiresAuth) {
                $username = Application_Model_Preferences::GetMailServerEmailAddress();
                $password = Application_Model_Preferences::GetMailServerPassword();

                $config = array(
                    'auth' => 'login',
                    'ssl' => 'ssl',
                    'username' => $username,
                    'password' => $password
                );
            } else {
                $config = array(
                    'ssl' => 'tls'
                );
            }

            if (isset($port)) {
                $config['port'] = $port;
            }

            $transport = new Zend_Mail_Transport_Smtp($mailServer, $config);
        }

        $mail = new Zend_Mail('utf-8');
        $mail->setSubject($subject);
        $mail->setBodyText($message);

        foreach ((array) $tos as $to) {
            $mail->addTo($to);
        }

        if ($mailServerConfigured) {
            $mail->setFrom(isset($from) ? $from : Application_Model_Preferences::GetMailServerEmailAddress());
            try {
                $mail->send($transport);
            } catch (Exception $e) {
                $success = false;
            }
        } else {
            $mail->setFrom(isset($from) ? $from : Application_Model_Preferences::GetSystemEmail());
            try {
                $mail->send();
            } catch (Exception $e) {
                $success = false;
            }
        }

        return $success;

    }
}
