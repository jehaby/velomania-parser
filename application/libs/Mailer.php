<?php


class Mailer
{

    public static function sendMail(array $emails, Pattern $pattern, array $themes)
    {

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->IsSMTP();
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = GMAIL_USERNAME;
        $mail->Password = GMAIL_PASSWORD;
        $mail->SetFrom("velomaniaparser@gmail.com");
        $mail->Subject = 'Новые темы для паттерна -- ' . $pattern->pattern;
        $mail->Body = self::makeBody($pattern, $themes);

        foreach ($emails as $email) {
            $mail->AddAddress($email);
        }
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message has been sent";
        }
    }

    private static function makeBody(Pattern $pattern, array $themes)
    {
        $res = '<body>';
        $res .= '<p> Привет! </p>';
        $res .= '<p> Есть новые темы для паттерна: ' . $pattern->pattern . '</p>';
        $res .= "<ul> \n";
        foreach ($themes as $theme) {
            $res .= "<li><a href='http://forum.velomania.ru/showthread.php?t={$theme->id}'> {$theme->title} </a></li> \n";
        }
        $res .= "</ul></body> \n";

        return $res;
    }

} 