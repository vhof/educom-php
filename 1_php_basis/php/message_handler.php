<?php require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php" ?>
<?php 
    $valid_message = false;
    $name_str = "name";
    $email_str = "email";
    $message_str = "message";
    $fields = array($name_str, $email_str, $message_str);
    $values = array($name_str => "", $email_str => "", $message_str => "");
    $errors = array($name_str => "", $email_str => "", $message_str => "");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $valid_message = true;

        $values[$name_str] = cleanInput($_POST[$name_str]);
        $values[$email_str] = cleanInput($_POST[$email_str]);
        $values[$message_str] = cleanInput($_POST[$message_str]);

        // Validate email
        if (!filter_var($values[$email_str], FILTER_VALIDATE_EMAIL)) {
            $errors[$email_str] = "Invalid email format";
            $valid_message = false;
        }

        // Check empty fields
        foreach ($fields as $field) {
            if (isEmpty($values[$field])) {
                $errors[$field] = "Required field";
                $valid_message = false;
            }
        }
    }

?>