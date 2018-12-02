<?php

namespace RecipeSystem\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Controller
{
    private $applicationarr;

    public function __construct()
    {
        $this->applicationarr = [
            'applicationurl' => '',
            'canonical' => '',
            'pagename' => 'main',
            'pagetitle' => 'Home',
            'title' => 'Home of Recipe',
            'author' => 'Tayyab Aziz',
        ];
    }

    public function setSetting($mydata)
    {
        $mydata['metas'] = [
            ['name' => 'title', 'content' => 'Home of Recipe'],
            ['name' => 'description', 'content' => 'Recipe - Temporary Meta Description Tag for testing only, website is not ready yet'],
            ['name' => 'author', 'content' =>  $mydata['author']],
            ['name' => 'keywords', 'content' => 'Recipe, recipes'],
            ['property' => 'og:locale', 'content' => 'en_US'],
            ['property' => 'og:type', 'content' => 'article'],
            ['property' => 'og:title', 'content' => $mydata['pagetitle'] . ' - Recipe'],
            ['property' => 'og:description', 'content' => 'Recipe'],
            ['property' => 'og:url', 'content' => $mydata['canonical']],
            ['property' => 'og:site_name', 'content' => 'Recipe'],
            ['property' => 'article:publisher', 'content' => "https://www.facebook.com/tayyab2318"],
            ['property' => 'article:author', 'content' => "https://www.facebook.com/tayyab2318"],
            ['property' => 'article:section', 'content' => $mydata['pagetitle'] . ' - Recipe'],
            ['property' => 'article:published_time', 'content' => "2018-07-11T14:30:12+02:00"],
            ['property' => 'article:modified_time', 'content' => "2018-07-11T15:19:50+02:00"],
            ['property' => 'og:updated_time', 'content' => "2018-07-11T15:19:50+02:00"],

            ['name' => 'twitter:card', 'content' => 'summary_large_image'],
            ['name' => 'twitter:description', 'content' => 'Recipe'],
            ['name' => 'twitter:title', 'content' => $mydata['pagetitle'] . ' - Recipe'],
            ['name' => 'twitter:site', 'content' => 'Recipe'],
            ['name' => 'twitter:creator', 'content' => '@tayyabaziz'],
        ];

        return $this->applicationarr = $mydata;
    }


    public function getApplicationSetting()
    {
        return $this->applicationarr;
    }

    public function setApplicationSetting($applicationarr)
    {
        $this->applicationarr = $applicationarr;
    }

    public function GetSystemIPAddress()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ipaddress = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public function twigrender($view, $data)
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__.'/../view/');
        $twig = new \Twig_Environment($loader, array(
            'debug' => true,
            // ...
        ));
        $twig->addExtension(new \Twig_Extension_Debug());
        $twig->addExtension(new \nochso\HtmlCompressTwig\Extension(true));

        $content = $twig->render($view, $data);

        echo $content;
    }

    public function view($value, $data = '')
    {
        include __DIR__."/../view/$value.php";
    }

    public function sendMail($fromemail, $fromname, $receiveremail, $ccemail, $bccemail, $receivername, $emailtext, $emailsubject, $attachments)
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'user@example.com';                 // SMTP username
            $mail->Password = 'secret';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            if ('' == $fromemail) {
                $mail->setFrom('test@test.com', 'Test');
            //$mail->AddReplyTo($fromemail,$fromname);
            } else {
                $mail->setFrom($fromemail, $fromname);
                $mail->setFrom('test@test.com', 'Test');
                $mail->AddReplyTo($fromemail, $fromname);
            }

            if ('' != $ccemail) {
                $ccemails = explode(',', $ccemail);
                foreach ($ccemails as $key => $value) {
                    $mail->addCC($value);
                }
            }
            if ('' != $bccemail) {
                $bccemails = explode(',', $bccemail);

                foreach ($bccemails as $key => $value) {
                    $mail->addBCC($value);
                }
            }
            if ('' != $receiveremail) {
                $receiveremails = explode(',', $receiveremail);
                foreach ($receiveremails as $key => $value) {
                    if ('' != $receivername) {
                        $mail->addAddress($value, $receivername);     // Add a recipient
                    } else {
                        $mail->addAddress($value, '');     // Add a recipient
                    }
                }
            }
            if ('' != $attachments) {
                foreach ($attachments as $key => $value) {
                    $mail->addAttachment($value);         // Add attachments
                }
            }

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $emailsubject;
            $mail->Body = $emailtext;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if (!$mail->send()) {
                echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
            } else {
                return true;
            }
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
        }
    }
}
