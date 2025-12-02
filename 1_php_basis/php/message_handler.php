<?php $root = $_SERVER['DOCUMENT_ROOT'];?>
<?php 
    require $root."/educom-php/1_php_basis/php/functions.php";
?>
<?php 
    $valid_message = false;
    $fields = array("name", "email", "message");
    $values = array("name" => "", "email" => "", "message" => "");
    $error = array("name" => "", "email" => "", "message" => "");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $valid_message = true;

        $values["name"] = clean_input($_POST["name"]);
        $values["email"] = clean_input($_POST["email"]);
        $values["message"] = clean_input($_POST["message"]);

        // Validate email
        if (!filter_var($values["email"], FILTER_VALIDATE_EMAIL)) {
            $error["email"] = "Invalid email format";
            $valid_message = false;
        }

        // Check empty fields
        foreach ($fields as $field) {
            if (is_empty($values[$field])) {
                $error[$field] = "Required field";
                $valid_message = false;
            }
        }
    }

?>