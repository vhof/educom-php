<!DOCTYPE html>
<?php require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php" ?>
<?php require __ROOT__."/php/message_handler.php" ?>
<?php browseHappy() ?>
<html>
    <?php head("Home") ?>
    <body>
        <?php browseHappyNotifier() ?>
        <?php navigation() ?>

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

        <?php footer() ?>
        <script src="" async defer></script>
    </body>
</html>