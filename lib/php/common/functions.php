<?php namespace lib;
require_once $_SERVER["DOCUMENT_ROOT"] . "/educom-php/importer.php";

//===================================
// Show page navigation
//===================================
function navigation(string $page_enum) {
    echo '<ul id="nav">';
    $pages = $page_enum::cases();
    foreach ($pages as $page) {
        echo '<a href="/educom-php/1_php_basis/?page='.$page->value.'"><li>'.strtoupper(displayName($page->value)).'</li></a>';
    }
    echo '</ul>';
}

//===================================
// Return true if $value is unset or an empty string
//===================================
function isEmpty(string $value) {
    return !isset($value) || $value === "";
}

//===================================
// Return $data without leading or trailing whitespace, backslashes, or special HTML chars
//===================================
function cleanInput(string $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function displayName($str): string {
    return str_replace("_", " ", $str);
}

function callableFromName(string $str): string {
    return lcfirst(str_replace("_","",ucwords($str,"_")));
}