<?php

// post data from index.php
if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $message = $_POST['message'];
    $subject = "Laundry Shop received your message";

    // formal email message
    $headers = "From: Laundry Shop \r\n";
    $headers .= "Reply-To: replyto@example.com\r\n";
    $headers .= "CC: cc@example.com\r\n";
    $headers .= "BCC: bcc@example.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $sender_name = "Laundry Shop";
    $sender_email = "ryanjamesc4@gmail.com";
    $recipient_email = $email;

    $body = "
    Dear $email,

We hope this email finds you well. We are pleased to inform you that your laundry is now ready for pickup at [Laundry Shop Name]. Our team has diligently worked to ensure that your clothes are clean, fresh, and ready for use.

Order Details:

Order Number: 342532564654
Pickup Date: January 1, 2021
Total Items: 5
Pickup Information:

Pickup Location: No. 123, Main Street, New York, NY 10030
Pickup Hours: 9:00 AM - 5:00 PM
Pickup Deadline: January 5, 2021
We kindly ask that you pick up your laundry by the specified deadline to avoid any inconvenience. If you are unable to pick up your items within the given timeframe, please contact us at [Laundry Shop Phone Number] to make alternative arrangements.

Thank you for choosing [Laundry Shop Name]. We appreciate your business and look forward to serving you again in the future.

Best regards,


Laundry Shop";

    if (mail($recipient_email, $subject, $body, "From: $sender_name <$sender_email>", $headers)) {
        echo "Success! Your email has been sent.";
    } else {
        echo "Failed to send email.";
    }
}
?>