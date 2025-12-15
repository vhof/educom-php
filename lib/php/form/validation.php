<?php namespace lib\form;

function validateRule(array &$fields, array $rule): void {
    $ruleCallable = $rule[RULE_CALLABLE_KEY];
    $satisfied = true;
    foreach ($rule[APPLIES_TO_KEY] as $field_name) {
        if (\is_callable($ruleCallable))
            $satisfied = $ruleCallable($rule, $fields, $field_name);
        else
            throw new \InvalidArgumentException($ruleCallable." should be callable with signature (array \$rule, array \$fields, string \$field_name): bool");
        
        if (!$satisfied) {
            $fields[$field_name][ERRORS_KEY][] = $rule[ERROR_KEY];
            $fields[$field_name][IS_VALID_KEY] = false;
        }
        
    }
}

/**
 * Validate each field according to its given rules
 * @param array $form
 * @return void
 */
function validateForm(array &$form): void {
    foreach ($form[RULES_KEY] as $rule) 
        validateRule($form[FIELDS_KEY], $rule);
    $form[IS_VALID_KEY] = isValidForm($form);
}

function isValidForm(array $form): bool {
    return \lib\array_all($form[FIELDS_KEY], fn($field) => $field[IS_VALID_KEY]);
}