<?php 
    defined("__ROOT__") || define("__ROOT__", $_SERVER["DOCUMENT_ROOT"]."/educom-php/1_php_basis");
    
    defined("__HOME__") || define("__HOME__", "home");
    defined("__ABOUT__") || define("__ABOUT__", "about");
    defined("__CONTACT__") || define("__CONTACT__", "contact");
    defined("__SIGNUP__") || define("__SIGNUP__", "signup");
    defined("__SIGNIN__") || define("__SIGNIN__", "signin");

    $pages = [
        __HOME__,
        __ABOUT__,
        __CONTACT__,
        __SIGNUP__,
        __SIGNIN__
    ];

    $page_names = [
        __HOME__ => "home",
        __ABOUT__ => "about",
        __CONTACT__ => "contact",
        __SIGNUP__ => "sign up",
        __SIGNIN__ => "sign in"
    ];

    defined("__PAGES__") || define("__PAGES__", $pages);
    defined("__PAGE_NAMES__") || define("__PAGE_NAMES__", $page_names);
    
    require_once __ROOT__."/php/functions.php";
?>