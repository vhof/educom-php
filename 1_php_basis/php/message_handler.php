<?php require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php" ?>
<?php require_once __ROOT__."/php/functions.php"; ?>
<?php 
    $valid_message = false;
    $fields = array("name", "email", "message");
    $values = array("name" => "", "email" => "", "message" => "");
    $error = array("name" => "", "email" => "", "message" => "");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $valid_message = true;

        $values["name"] = cleanInput($_POST["name"]);
        $values["email"] = cleanInput($_POST["email"]);
        $values["message"] = cleanInput($_POST["message"]);

        // Validate email
        if (!filter_var($values["email"], FILTER_VALIDATE_EMAIL)) {
            $error["email"] = "Invalid email format";
            $valid_message = false;
        }

        // Check empty fields
        foreach ($fields as $field) {
            if (isEmpty($values[$field])) {
                $error[$field] = "Required field";
                $valid_message = false;
            }
        }
    }

?>