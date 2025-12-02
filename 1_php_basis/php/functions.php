<?php 
    function is_empty($value) {
        return !isset($value) || $value === "";
    }

    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>