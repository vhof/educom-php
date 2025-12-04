<!DOCTYPE html>
<?php require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php" ?>
<?php browseHappy() ?>
<html>
    <?php 
        $home = "home";
        $about = "about";
        $contact = "contact";

        if (isset($_GET["page"])) {
            $page = $_GET["page"];

            switch ($page) {
                case $about:
                    page($about);
                    break;
                case $contact:
                    page($contact);
                    break;
                default:
                    http_response_code(404);
                    echo "404: Page not found";
            }
        }
        else {
            page($home);
        }
    ?>
</html>