<?php namespace lib\account;

function createUser(array &$user): array|bool {
    if (!($userFile = openConnection())) return false;
    if (!fwrite($userFile, serializeUser($user)."\n")) return false;
    if (!closeConnection($userFile)) return false;
    return $user;
}

function readUser(string $email): array|bool {
    if (!($userFile = openConnection())) return false;
    $found_user = false;
    $user = [];
    while ($userData = fgets($userFile)) {
        $user = unserializeUser($userData);
        if ($email == $user[USER_EMAIL_KEY]) {
            $found_user = $user;
            break;
        }
    }
    if (!closeConnection($userFile)) return false;
    return $found_user;
}

// Not required yet
function updateUser(array &$user): bool {
    throw new \Error("Not implemented yet");
}

// Not required yet
function deleteUser(array &$user): bool {
    throw new \Error("Not implemented yet");
}