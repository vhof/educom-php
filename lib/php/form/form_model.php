<?php namespace lib\form;

/**
 * @param array<array{
 *      name: string, 
 *      value: string,
 *      type: callable,
 *      rules: array<callable>,
 *      error_msg: string,
 *      placeholder?: string,
 * }>  $fields
 * 
 * @return string Produce a Form based on $fields
 */
function formModel(string $action_url, array $fields): string {
    $result = "<p><form action='$action_url' method='POST'>";
    foreach ($fields as $field) {
        $result .= $field["type"]($field);
    }
    $result .= 
        "<input type='submit' id='send_button' name='send_button' value='Send'>"
        ."</form></p>";
    return $result;
}