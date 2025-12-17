<?php namespace lib\account;

const USER_NAME_KEY = "name";
const USER_EMAIL_KEY = "email";
const USER_PWD_KEY = "pwd";

function newUser(string $email, string $pwd, string $name = ""): array {
    return [
        USER_NAME_KEY => $name,
        USER_EMAIL_KEY => $email,
        USER_PWD_KEY => $pwd,
    ];
}

function serializeUser(array &$user): string {
    return $user[USER_EMAIL_KEY]."|".$user[USER_NAME_KEY]."|".$user[USER_PWD_KEY];
}

function unserializeUser(string $data): array {
    [$email, $name, $pwd] = \sscanf($data, "%[^|]|%[^|]|%[^\n]");
    return newUser($email, $pwd, $name);
}