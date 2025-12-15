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
 *      IS_VALID_KEY: bool,
 * }
 */
function newForm(array $fields, array $rules, string $action_url): array {
    return [
        FIELDS_KEY => $fields,
        RULES_KEY => $rules,
        ACTION_KEY => $action_url,
        IS_VALID_KEY => true,
    ];
}

function populateForm(array &$form, array $values): void {
    foreach ($values as $field_name => $field_value)
        if ($form[FIELDS_KEY][$field_name])
            // TODO Sanitizer?
            $form[FIELDS_KEY][$field_name][VALUE_KEY] = \lib\cleanInput($field_value);
}

function loadForm(array $form): void {
    echo formModel($form);
}

function loadFormResponse(array $form): void {
    foreach ($form[FIELDS_KEY] as $field) 
        echo '<p>'.\lib\displayName($field[NAME_KEY]).': '.$field[VALUE_KEY].'</p>';
    echo '<a href=""><button>Nieuw bericht</button></a>';
}