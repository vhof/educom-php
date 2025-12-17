<?php namespace lib\form;

function isFieldRequired(array &$form, string $field_name): bool {
    $require_rules = array_filter($form[RULES_KEY], fn($rule) => $rule[RULE_CALLABLE_KEY] == NONEMPTY_RULE_CALLABLE);
    $required_field_names = array_reduce($require_rules, fn($carry, $rule) => array_merge($carry, $rule[APPLIES_TO_KEY]), []);
    return \in_array($field_name, $required_field_names);
}