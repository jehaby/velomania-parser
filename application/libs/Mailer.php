<?php


class Mailer
{


    public static function sendMail($email, $username, $pattern, $themes)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
//        d(self::makeBody($username, $pattern, $themes));
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = GMAIL_USERNAME;
        $mail->Password = GMAIL_PASSWORD;
        $mail->SetFrom("velomaniaparser@gmail.com");
        $mail->Subject = 'Новые темы для паттерна -- ' . $pattern;
        $mail->Body = self::makeBody($username, $pattern, $themes);
        $mail->AddAddress($email);
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message has been sent";
        }
    }

    private static function makeBody($username, $pattern, $themes)
    {
        d($themes);
        $res = '<body>';
        $res .= '<p> Hello, ' . $username . '</p>';
        $res .= '<p> Есть новые темы для паттерна: ' . $pattern->pattern . '</p>';
        $res .= "<ul> \n";
        foreach ($themes as $theme) {
            $res .= "<li><a href='http://forum.velomania.ru/showthread.php?t={$theme->id}'> {$theme->title} </a></li> \n";
        }
        $res .= "</ul></body> \n";

        return $res;
    }

} 