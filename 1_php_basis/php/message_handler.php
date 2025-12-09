<?php require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php" ?>
<?php 
    $is_valid = false;

    $values = array($name_str => "", $email_str => "", $message_str => "");
    $errors = array($name_str => "", $email_str => "", $message_str => "");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $is_valid = true;

        $values[$name_str] = \lib\cleanInput($_POST[$name_str]);
        $values[$email_str] = \lib\cleanInput($_POST[$email_str]);
        $values[$message_str] = \lib\cleanInput($_POST[$message_str]);

        // Validate email
        if (!filter_var($values[$email_str], FILTER_VALIDATE_EMAIL)) {
            $errors[$email_str] = "Invalid email format";
            $is_valid = false;
        }

        // Check empty fields
        foreach ($field_names as $field) {
            if (\lib\isEmpty($values[$field])) {
                $errors[$field] = "Required field";
                $is_valid = false;
            }
        }
    }

?>