<?php namespace lib\form;

//===================================
// Return HTML for user input as string
//===================================
function fieldModel(array $field, string $field_type_model): string {
    $result = 
        '<p>'
        .'<label for="'.$field["name"].'">'.ucfirst($field["name"]).':</label>'
        .$field_type_model
        .'<span class="error">* '.$field["error_msg"].'</span>'
        .'</p>';
    return $result;
}

//===================================
// Return HTML for text input field
//===================================
function textFieldModel(array $field): string {
    $model = '<input type="text" id="'.$field["name"].'" name="'.$field["name"].'" placeholder="'.$field["placeholder"].'" value="'.$field["value"].'"></input>';
    return fieldModel($field, $model);
}

//===================================
// Return HTML for area input field
//===================================
function areaFieldModel(array $field): string {
    $model = '<textarea id="'.$field["name"].'" name="'.$field["name"].'" placeholder="'.$field["placeholder"].'">'.$field["value"].'</textarea>';
    return fieldModel($field, $model);
}

const NS = __NAMESPACE__.'\\';
const TEXTFIELD_CALLABLE = NS."textFieldModel";
const AREAFIELD_CALLABLE = NS."areaFieldModel";