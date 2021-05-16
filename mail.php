<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.

        $json = array();
        $name = strip_tags(trim($_POST["cf_name"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["cf_email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["cf_message"]);


        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $json['status'] = 400;
            $json['message'] = "Validation error please try again!";
            echo json_encode($json);
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "webmaster@chenzhangbao.com";

        // Set the email subject.
        $subject = "Nuevo contacto de $name";

        // Build the email content.
        $email_content = "Nombre: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Asunto: $subject\n\n";
        $email_content .= "Mensaje:\n$message\n";

        // Build the email headers.
        $email_headers = "De: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
        
            $json['status'] = 200;
            $json['message'] = "¡Muchas Gracias! Tu mensaje se ha enviado correctamente.";
        
        } else {
        
            $json['status'] = 500;
            $json['message'] = "Oops! Algo esta fallando y no podemos enviar el mensanje.";
        
        }

    } else {

        $json['status'] = 403;
        $json['message'] = "Hay algun problema con el envio, porfavor prueba otra vez.";

    }

echo json_encode($json);

?>

