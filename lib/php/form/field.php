<?php namespace lib\form;

/**
 * Returns a blank Field struct
 * @param string $name
 * @param callable $type
 * @param string $value
 * @param ?string $placeholder
 * @return array{
 *      name: string, 
 *      type: callable, 
 *      value: string,
 *      rules: array, 
 *      error_msg: string, 
 *      placeholder: string, 
 * } Field
 */
function newField(string $name, string $type, string $value = "", ?string $placeholder = null): array {
    if (!is_callable($type)) throw new \InvalidArgumentException("type must be callable");
    return [
        "name" => $name, 
        "value" => $value,
        "type" => $type,
        "rules" => [],
        "error_msg" => "",
        "placeholder" => $placeholder ?? ucfirst($name),
    ];
}

/**
 * Returns an array of blank Field structs based on $field_data
 * @param array $field_data
 * @return array{
 *      name: array{
 *          name: string, 
 *          type: callable, 
 *          value: string,
 *          rules: array, 
 *          error_msg: string, 
 *          placeholder: string, 
 *      }
 * }
 */
function newFields(array $field_data): array {
    $fields = [];
    foreach ($field_data as [$name, $type])
        $fields[$name] = newField($name, $type);
    return $fields;
}