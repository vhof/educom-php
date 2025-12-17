<?php namespace lib\form;

function nonEmptyRule(array $rule, array &$fields, string $curr_field_name): bool {
    return !\lib\isEmpty($fields[$curr_field_name][VALUE_KEY]);    
}

function emailRule(array $rule, array &$fields, string $curr_field_name): bool {
    return \filter_var($fields[$curr_field_name][VALUE_KEY], FILTER_VALIDATE_EMAIL);    
}

function equalityRule(array $rule, array &$fields, string $curr_field_name): bool {
    $applies_to = $rule[APPLIES_TO_KEY];
    return \count(array_unique(array_map(function($applicant_field_name) use ($fields): string {
        return $fields[$applicant_field_name][VALUE_KEY];
    }, $applies_to))) == 1;
}

function newRule (string $callable, array|string $applies_to, array $error): array {
    return [
        RULE_CALLABLE_KEY => $callable,
        APPLIES_TO_KEY => \is_array($applies_to) ? $applies_to : [$applies_to],
        ERROR_KEY => $error,
    ]; 
}

function newNonEmptyRule(array|string $applies_to): array {
    return newRule(NONEMPTY_RULE_CALLABLE, $applies_to, NONEMPTY_ERROR);
}

function newEmailRule(array|string $applies_to): array {
    return newRule(EMAIL_RULE_CALLABLE, $applies_to, EMAIL_ERROR);
}

function newEqualityRule(array|string $applies_to): array {
    return newRule(EQUALITY_RULE_CALLABLE, $applies_to, EQUALITY_ERROR);
}