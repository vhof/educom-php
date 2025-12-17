<?php namespace _1_php_basis;

//===================================
// Load the website
//===================================
function init(): void {
    $page_name = \lib\getPage(__HOME_PAGE__->value, Page::values());
    \lib\loadPage($page_name, Page::sessionPages(), Page::nonSessionPages(), __NAMESPACE__);
}