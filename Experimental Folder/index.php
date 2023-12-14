<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/Bootstrap-css/bootstrap.css">
    <link rel="stylesheet" href="./Style/Fonts.css">
    <title></title>
</head>

<body>
    <div class="container-xl">
        <form action="emailsender.php" method="POST">
            <!-- send email message -->
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" placeholder="Enter email" class="form-control" id="email" aria-describedby="emailHelp">
            </div>
            <!-- send message -->
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" placeholder="Enter message" class="form-control" id="message" rows="3"></textarea>
            </div>
            <!-- send button -->
            <button type="submit" name="send" class="btn btn-primary">Send</button>

        </form>
    </div>
</body>

</html>