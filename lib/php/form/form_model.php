<?php namespace lib\form;

/**
 * Returns a new form
 * @param array{
 *      NAME_KEY: array{
 *          NAME_KEY: string, 
 *          TYPE_KEY: callable, 
 *          VALUE_KEY: string,
 *          ERRORS_KEY: array, 
 *          PLACEHOLDER_KEY: string, 
 *          IS_VALID_KEY: bool,
 *      }
 * } $fields
 * @param array $rules
 * @param string $action_url
 * @return array{
 *      FIELDS_KEY: array,
 *      RULES_KEY: array,
 *      ACTION_KEY: string,
 *      SUBMIT_TEXT_KEY: string,
 *      IS_VALID_KEY: bool,
 * }
 */
function newForm(string $title, array $fields, array $rules, string $action_url, string $submit_text, string $error_msg): array {
    return [
        TITLE_KEY => $title,
        FIELDS_KEY => $fields,
        RULES_KEY => $rules,
        ACTION_KEY => $action_url,
        SUBMIT_TEXT_KEY => $submit_text,
        ERROR_MSG_KEY => $error_msg,
        IS_VALID_KEY => true,
    ];
}

function populateForm(array &$form, array $values): void {
    foreach ($values as $field_name => $field_value)
        if ($form[FIELDS_KEY][$field_name])
            // TODO Sanitizer?
            $form[FIELDS_KEY][$field_name][VALUE_KEY] = \lib\cleanInput($field_value);
}

function getValues(array &$form): array {
    return array_map(fn($field) => $field[VALUE_KEY], $form[FIELDS_KEY]);
}