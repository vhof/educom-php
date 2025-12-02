<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->
<?php $root = $_SERVER['DOCUMENT_ROOT'];?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Contact</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/educom-php/1_php_basis/stylesheets/style.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php include($root."/educom-php/1_php_basis/php/navigation.php") ?>

        <h1>Contact</h1>
        <p>
            <form action="">
                <label for="name_input">Naam:</label><input type="text" id="name_input" name="name_input" placeholder="Naam"></input><br>
                <label for="email_input">Email:</label><input type="text" id="email_input" name="email_input" placeholder="Email"></input><br>
                <label for="message_input">Bericht:</label><textarea id="message_input" name="message_input" placeholder="Bericht" rows="6"></textarea><br>
                <input type="submit" id="send_button" name="send_button" value="Verstuur">
            </form>
        </p>
        <?php include($root."/educom-php/1_php_basis/php/footer.php") ?>
        <script src="" async defer></script>
    </body>
</html>