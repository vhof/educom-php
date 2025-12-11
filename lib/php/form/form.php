<?php namespace lib\form;

use function lib\displayName;

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
 * Show a Form page based on $fields
 */
function formPage(string $page_name, array $fields): void {
    echo "<h1>".displayName($page_name)."</h1>";
    $action_url = htmlspecialchars($_SERVER["PHP_SELF"]."?page=".$page_name);
    echo formModel($action_url, $fields);
}