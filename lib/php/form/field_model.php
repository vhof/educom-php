<?php namespace lib\form;

//===================================
// Return HTML for user input as string
//===================================
function fieldModel(array $field, string $field_type_model): string {
    $result = 
        '<p>'
        .'<label for="'.$field[NAME_KEY].'">'.\lib\displayName($field[NAME_KEY]).':</label>'
        .$field_type_model
        .'<span class="error">* '.getErrorMsg($field).'</span>'
        .'</p>';
    return $result;
}

//===================================
// Return HTML for text input field
//===================================
function textFieldModel(array $field): string {
    $model = '<input type="text" id="'.$field[NAME_KEY].'" name="'.$field[NAME_KEY].'" placeholder="'.$field[PLACEHOLDER_KEY].'" value="'.$field[VALUE_KEY].'"></input>';
    return fieldModel($field, $model);
}

//===================================
// Return HTML for area input field
//===================================
function areaFieldModel(array $field): string {
    $model = '<textarea id="'.$field[NAME_KEY].'" name="'.$field[NAME_KEY].'" placeholder="'.$field[PLACEHOLDER_KEY].'">'.$field[VALUE_KEY].'</textarea>';
    return fieldModel($field, $model);
}