<?php namespace lib\account;

function openConnection(): mixed {
    return fopen(USER_FILE, "a+");
}

function closeConnection($file): void {
    fclose($file);
}

function inSession(): bool {
    return isset($_COOKIE["PHPSESSID"]);
}

function signedIn(): bool {
    return inSession() && isset($_SESSION[USER_EMAIL_KEY]);
}

function getSignedUserName(): string {
    if (signedIn()) {
        $email = $_SESSION[USER_EMAIL_KEY];
        $user = readUser($email);
        return getUserName($user);
    }
    else return "";
}

function getSignedUserEmail(): string {
    return $_SESSION[USER_EMAIL_KEY] ?? "";
}