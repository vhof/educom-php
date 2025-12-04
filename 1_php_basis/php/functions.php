<?php 
    //===================================
    // Return true if $value is unset or an empty string
    //===================================
    function isEmpty($value) {
        return !isset($value) || $value === "";
    }

    //===================================
    // Return $data without leading or trailing whitespace, backslashes, or special HTML chars
    //===================================
    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //===================================
    // Show browse happy preamble
    //===================================
    function browseHappy() {
        echo "
            <!--[if lt IE 7]>      <html class='no-js lt-ie9 lt-ie8 lt-ie7'> <![endif]-->
            <!--[if IE 7]>         <html class='no-js lt-ie9 lt-ie8'> <![endif]-->
            <!--[if IE 8]>         <html class='no-js lt-ie9'> <![endif]-->
            <!--[if gt IE 8]>      <html class='no-js'> <![endif]-->
        ";
    }

    //===================================
    // Show outdated browser notification
    //===================================
    function browseHappyNotifier() {
        echo "
            <!--[if lt IE 7]>
                <p class='browsehappy'>You are using an <strong>outdated</strong> browser. Please <a href='#'>upgrade your browser</a> to improve your experience.</p>
            <![endif]-->
        ";
    }

    //===================================
    // Show HTML head element with $title as title
    //===================================
    function head($title) {
        echo "
            <head>
                <meta charset='utf-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <title>".$title."</title>
                <meta name='description' content=''>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <link rel='stylesheet' href='/educom-php/1_php_basis/stylesheets/style.css'>
            </head>
        ";
    }

    //===================================
    // Show page navigation
    //===================================
    function navigation() {
        echo "
            <ul id='nav'>
                <a href='/educom-php/1_php_basis/'><li>HOME</li></a>
                <a href='/educom-php/1_php_basis/about'><li>ABOUT</li></a>
                <a href='/educom-php/1_php_basis/contact'><li>CONTACT</li></a>
            </ul>
        ";
    }

    //===================================
    // Show page footer with current year
    //===================================
    function footer() {
        echo "
            <div id='footer'>
                &copy;".date('Y')."Vincent van 't Hof
            </div>
        ";
    }
?>