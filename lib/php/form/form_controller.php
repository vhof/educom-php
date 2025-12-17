<?php namespace lib\form;

/**
 * @param array<array{
 *      NAME_KEY: string, 
 *      TYPE_KEY: callable,
 *      VALUE_KEY: string,
 *      ERRORS_KEY: array,
 *      PLACEHOLDER_KEY: string,
 *      IS_VALID_KEY: bool,
 * }>  $fields
 * 
 * Show a Form page based on $fields
 */
function loadForm(string $page_name, string $responseCallable, array $field_data, array $rules, string $submit_text, string $error_msg): void {
    $title = \lib\displayName($page_name);
    $action_url = htmlspecialchars($_SERVER["PHP_SELF"]."?page=".$page_name);
    $fields = newFields($field_data);
    $form = newForm($title, $fields, $rules, $action_url, $submit_text, $error_msg);

    $is_valid = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $values = array_intersect_key($_POST, $fields);
        populateForm($form, $values);
        validateForm($form);
        $is_valid = $form[IS_VALID_KEY];
    }

    if ($is_valid) 
        $responseCallable($form);
    else
        drawForm($form);
}