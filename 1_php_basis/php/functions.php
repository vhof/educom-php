<?php 
    function isEmpty($value) {
        return !isset($value) || $value === "";
    }

    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>