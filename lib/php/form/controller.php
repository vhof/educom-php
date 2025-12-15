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
function formPage(string $page_name, array $field_data, array $rules): void {
    $action_url = htmlspecialchars($_SERVER["PHP_SELF"]."?page=".$page_name);
    $fields = newFields($field_data);
    $form = newForm($fields, $rules, $action_url);

    $is_valid = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $values = array_intersect_key($_POST, $fields);
        populateForm($form, $values);
        validateForm($form);
        $is_valid = $form[IS_VALID_KEY];
    }

    echo "<h1>".\lib\displayName($page_name)."</h1>";

    if ($is_valid) 
        loadFormResponse($form);
    else
        loadForm($form);


}