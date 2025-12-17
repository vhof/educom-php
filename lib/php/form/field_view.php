<?php namespace lib\form;

//===================================
// Return HTML for user input as string
//===================================
function fieldView(array $field, string $field_type_model, bool $required): string {
    $result = 
        '<p>'
        .'<label for="'.$field[NAME_KEY].'">'.\lib\displayName($field[NAME_KEY]).':</label>'
        .$field_type_model
        .'<span class="error">'.($required ? '*' : '').' '.getErrorMsg($field).'</span>'
        .'</p>';
    return $result;
}

//===================================
// Return HTML for text input field
//===================================
function textfieldView(array $field, bool $required = false): string {
    $model = '<input type="text" id="'.$field[NAME_KEY].'" name="'.$field[NAME_KEY].'" placeholder="'.$field[PLACEHOLDER_KEY].'" value="'.$field[VALUE_KEY].'"></input>';
    return fieldView($field, $model, $required);
}

//===================================
// Return HTML for area input field
//===================================
function areafieldView(array $field, bool $required = false): string {
    $model = '<textarea id="'.$field[NAME_KEY].'" name="'.$field[NAME_KEY].'" placeholder="'.$field[PLACEHOLDER_KEY].'">'.$field[VALUE_KEY].'</textarea>';
    return fieldView($field, $model, $required);
}