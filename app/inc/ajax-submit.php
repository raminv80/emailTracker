<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use \App\PixelTrracker;

class AjaxSubmit{
    /*
     * get inputs from post data
     */
    function getInput($name){
        return trim($_POST[$name]);
    }

    /*
     * validate post fields
     */
    function validate($email, $subject, $message) {
        $messages = [];
        if($email=='') $messages[] = 'Email is required';
        if($subject=='') $messages[] = 'Subject is required';
        if($message=='') $messages[] = 'Message is required';
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $message[] = 'Email is invalid';
        return $messages;
    }

    /*
     * process the request
     */
    function process(){
        $email = $this->getInput('email');
        $subject = $this->getInput('subject');
        $message = $this->getInput('message');

        $errors = $this->validate($email, $subject, $message);

        if(count($errors)>0){
            $res = ['message'=>'error', 'desc'=> $errors];
        }else{
            $message = $this->composeMessage($email, $subject, $message);

            if($this->email($email, $subject, $message)){
                $res = ['message'=>'success'];
            } else {
                $res = ['message'=>'error', 'desc'=> 'Email can not be sent!'];
            }
        }

        return $res;
    }

    /*
     * Add message to email template
     */
    function composeMessage($email, $subject, $message) {
        $pixelTracker = new PixelTrracker();
        $token = $pixelTracker->create($email, $subject, $message);
        $server = SITE_HOME;
        $template = $body = file_get_contents(__DIR__."/emailTemplate.html");
        $template = str_replace('{{token}}', $token, $template);
        $template = str_replace('{{server}}', $server, $template);
        $message = str_replace('{{message}}', $message, $template);

//        // todo create an email template
//        $message = <<<EOD
//<p>$message</p>
//<img src="$server/tracker-$token.jpg">
//EOD;
        return $message;
    }

    function email($email, $subject, $message){
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->CharSet = 'UTF-8';
            if(SMTP_SECURE === 'yes') $mail->SMTPSecure = "tls"; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = SMTP_PORT;

            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($email);     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Message could not be sent. Mailer Error: '. $mail->ErrorInfo);
            return false;
        }
    }
}

$instance = new AjaxSubmit();
echo json_encode($instance->process());
