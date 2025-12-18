<?php namespace _1_php_basis;

//===================================
// Load the website
//===================================
function init(): void {
    \import(\Library::Account);

    // Manage session
    session_start();
    if (isset($_GET[\lib\account\SIGNOUT_KEY])) \lib\account\signOut();

    // Load requested page
    $page_name = getPageName();
    loadPage($page_name);
}