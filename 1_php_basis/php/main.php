<?php namespace _1_php_basis;

//===================================
// Load the website
//===================================
function init(): void {
    \import(\Library::Account);
    session_start();
    $page_name = \lib\getPage(__HOME_PAGE__->value, Page::values());
    $page_names = \lib\account\signedIn() 
        ? Page::sessionPages()
        : Page::nonSessionPages();
    \lib\loadPage($page_name, $page_names, __NAMESPACE__);
}