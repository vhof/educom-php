<?php namespace lib\account;

function signOut(): void {
    session_unset();
    session_destroy();
}