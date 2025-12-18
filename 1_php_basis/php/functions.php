<?php namespace _1_php_basis;

use const lib\PAGE_KEY;

function getPagesEnum(): array {
    return \lib\account\signedIn() 
        ? Page::sessionPages()
        : Page::nonSessionPages();
}

function getPageName() {
    $page_enums = getPagesEnum();
    $page_names = Page::getPageNames($page_enums);

    return \lib\getPage(__HOME_PAGE__->value, $page_names);
}

function loadPage(string $page_name) {
    $_SESSION[PAGE_KEY] = $page_name;
    $base_url = $_SERVER["SCRIPT_NAME"];
    $page_enums = getPagesEnum();
    $pages = Page::getPages($page_enums);
    
    \lib\loadPage($base_url, $page_name, $pages, __NAMESPACE__);
}