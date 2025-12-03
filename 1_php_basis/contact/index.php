<?php require $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php" ?>
<?php 
    require ROOT_STR."/educom-php/1_php_basis/php/message_handler.php";
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->
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

        <?php include(ROOT_STR."/educom-php/1_php_basis/php/navigation.php") ?>

        <h1>Contact</h1>
        <?php if (!$valid_message) { ?>
            <p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <label for="name">Naam:</label>
                    <input type="text" id="name" name="name" placeholder="Naam" value="<?php echo $values["name"] ?>"></input>
                    <span class="error">* <?php echo $error["name"];?></span>
                    <br>
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" placeholder="Email" value="<?php echo $values["email"] ?>"></input>
                    <span class="error">* <?php echo $error["email"];?></span>
                    <br>
                    <label for="message">Bericht:</label>
                    <textarea id="message" name="message" placeholder="Bericht" rows="6"><?php echo $values["message"] ?></textarea>
                    <span class="error">* <?php echo $error["message"];?></span>
                    <br>
                    <input type="submit" id="send_button" name="send_button" value="Verstuur">
                </form>
            </p>
        <?php } else { ?>
            <p>Naam: <?php echo $values["name"] ?></p>
            <p>Email: <?php echo $values["email"] ?></p>
            <p>Bericht: <?php echo $values["message"] ?></p>
            <a href=""><button>Nieuw bericht</button></a>
        <?php } ?>

        <?php include(ROOT_STR."/educom-php/1_php_basis/php/footer.php") ?>
        <script src="" async defer></script>
    </body>
</html>