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
function drawForm(array &$form): void {
    $required = false;
    $result = "<h1>".$form[TITLE_KEY]."</h1>";
    $result .= "<p><form action=".$form[ACTION_KEY]." method='POST'>";
    foreach ($form[FIELDS_KEY] as $field) {
        $required = isFieldRequired($form, $field[NAME_KEY]);
        $result .= $field[TYPE_KEY]($field, $required);
    }

    if ($form[ERROR_MSG_KEY]) 
        $result .= "<div id='form_error'>".$form[ERROR_MSG_KEY]."</div>";

    $result .= "<input type='submit' id='submit_button' name='submit_button' value='".$form[SUBMIT_TEXT_KEY]."'>"
        ."</form></p>";
    echo $result;
}