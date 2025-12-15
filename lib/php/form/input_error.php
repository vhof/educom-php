<?php namespace lib\form;

function getErrorMsg(array &$field): string {
    usort($field[ERRORS_KEY], fn($a, $b) => $a[PRECEDENCE_KEY] <=> $b[PRECEDENCE_KEY]);
    return $field[ERRORS_KEY][0][ERROR_MSG_KEY] ?? "";
}