<?php namespace lib\account;

function signUp(string $email, string $name, string $pwd): array|bool {
    if (!readUser($email)) {
        $user = newUser($email, $pwd, $name);
        return createUser($user);
    }
    return false;
}