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

function responseCallableFromName(string $name, string $namespace = "\\"): string {
    return callableFromName($name, $namespace)."Response";
}

/** 
 * Backport from PHP 8.4 
 * @ref https://www.php.net/manual/en/function.array-all.php
 */
if (!function_exists('array_all')) {
    function array_all(array $array, callable $callable) {
        foreach ($array as $key => $value) {
            if (!$callable($value, $key))
                return false;
        }
        return true;
    }
}

function getPage(string $default_page_name, array $page_names): string {
    $url_page = $_GET[PAGE_KEY] ?? $default_page_name;
    $page_name = array_search($url_page, $page_names) ? $url_page : $default_page_name;
    return $page_name;
}

//===================================
// Show page $page
//===================================
function loadPage(string $base_url, string $page_name, array $pages, string $namespace): void {
    echo browseHappy();
    echo '<html>';
    echo head($page_name);
    echo '<body>'; 
    echo browseHappyNotifier(); 
    echo navigation($base_url, $pages); 
    $pageCallable = callableFromName($page_name, $namespace);
    $pageCallable();
    echo footer();
    echo '</body>';
    echo '</html>';
}