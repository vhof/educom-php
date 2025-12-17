<?php namespace lib\account;
use const lib\RETURN_PAGE_KEY;

function signOut(): void {
    $return_page = $_SESSION[RETURN_PAGE_KEY];
    session_unset();
    header("Location: ". htmlspecialchars($_SERVER["SCRIPT_NAME"]."?page=".$return_page));
    exit();
}