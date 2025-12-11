<?php namespace lib;

//===================================
// Return true if $value is unset or an empty string
//===================================
function isEmpty(string $value): bool {
    return !isset($value) || $value === "";
}

//===================================
// Return $data without leading or trailing whitespace, backslashes, or special HTML chars
//===================================
function cleanInput(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function displayName(string $name): string {
    return ucfirst(str_replace("_", " ", $name));
}

function callableFromName(string $name, string $namespace = "\\"): string {
    return $namespace."\\".lcfirst(str_replace("_","",ucwords($name,"_")));
}

function getPage(string $default_page_name, array $page_names): string {
    $url_page = $_GET["page"] ?? $default_page_name;
    $page_name = array_search($url_page, $page_names) ? $url_page : $default_page_name;
    return $page_name;
}

//===================================
// Show page $page
//===================================
function loadPage(string $page_name, array $page_names, string $namespace): void {
    echo browseHappy();
    echo '<html>';
    echo head($page_name);
    echo '<body>'; 
    echo browseHappyNotifier(); 
    echo navigation($page_names); 
    $pageCallable = callableFromName($page_name, $namespace);
    $pageCallable();
    echo footer();
    echo '</body>';
    echo '</html>';
}