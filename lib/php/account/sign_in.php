<?php namespace lib\account;

enum SignInError: string {
    case Nonexistent = "Nonexistent user";
    case WrongPwd = "Password incorrect";
}

function signIn(string $email, string $pwd): SignInError|bool {
    $user = readUser($email);
    echo var_dump($user)."<br>";
    echo var_dump($pwd)."<br>";

    if (!$user) return SignInError::Nonexistent;
    if ($user[USER_PWD_KEY] !== $pwd) return SignInError::WrongPwd;
    
    $_SESSION[USER_NAME_KEY ] = $user[USER_NAME_KEY ];
    $_SESSION[USER_EMAIL_KEY] = $user[USER_EMAIL_KEY];
    return true;
}