<?php namespace lib\account;

function openConnection(): mixed {
    return fopen(USER_FILE, "a+");
}

function closeConnection($file): void {
    fclose($file);
}

function userExists(array &$users, string $email): bool {
    return false;
}