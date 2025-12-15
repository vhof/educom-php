<?php namespace lib\form;

/**
 * @param array<array{
 *      NAME_KEY: string, 
 *      TYPE_KEY: string,
 *      VALUE_KEY: callable,
 *      ERRORS_KEY: array,
 *      PLACEHOLDER_KEY: string,
 *      IS_VALID_KEY: bool,
 * }>  $fields
 * 
 * @return string Produce a Form based on $fields
 */
function formModel(array $form): string {
    $result = "<p><form action=".$form[ACTION_KEY]." method='POST'>";
    foreach ($form[FIELDS_KEY] as $field) {
        $result .= $field[TYPE_KEY]($field);
    }
    $result .= 
        "<input type='submit' id='send_button' name='send_button' value='Send'>"
        ."</form></p>";
    return $result;
}