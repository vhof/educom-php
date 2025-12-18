<?php namespace lib\account;

use const lib\PAGE_KEY;

function signOut(): void {
    unset($_SESSION[USER_EMAIL_KEY]);
    unset($_SESSION[USER_NAME_KEY]);
}