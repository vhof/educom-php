<?php 
    defined("__ROOT__") || define("__ROOT__", $_SERVER["DOCUMENT_ROOT"]."/educom-php/1_php_basis");
    
    $pages = array(
        "home" => "home",
        "about" => "about",
        "contact" => "contact"
    );

    defined("__PAGES__") || define("__PAGES__", $pages);
    defined("__HOME__") || define("__HOME__", __PAGES__["home"]);
    
    require_once __ROOT__."/php/functions.php";
?>