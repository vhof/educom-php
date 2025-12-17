<?php namespace lib\form;

/**
 * Returns a blank Field struct
 * @param string $name
 * @param callable $type
 * @param string $value
 * @param ?string $placeholder
 * @return array{
 *      NAME_KEY: string, 
 *      TYPE_KEY: callable, 
 *      VALUE_KEY: string,
 *      ERRORS_KEY: array, 
 *      PLACEHOLDER_KEY: string, 
 *      IS_VALID_KEY: bool,
 * } Field
 */
function newField(string $name, string $type, string $value = "", ?string $placeholder = null): array {
    if (!is_callable($type)) throw new \InvalidArgumentException("type must be callable");
    return [
        NAME_KEY => $name, 
        TYPE_KEY => $type,
        VALUE_KEY => $value,
        ERRORS_KEY => [],
        PLACEHOLDER_KEY => $placeholder ?? \lib\displayName($name),
        IS_VALID_KEY => true,
    ];
}

/**
 * Returns an array of blank Field structs based on $field_data
 * @param array $field_data
 * @return array{
 *      NAME_KEY: array{
 *          NAME_KEY: string, 
 *          TYPE_KEY: callable, 
 *          VALUE_KEY: string,
 *          ERRORS_KEY: array, 
 *          PLACEHOLDER_KEY: string, 
 *          IS_VALID_KEY: bool,
 *      }
 * }
 */
function newFields(array $field_data): array {
    $fields = [];
    foreach ($field_data as $field_datum) {
        $default_value = "";
        \count($field_datum) == 3
        ? [$name, $type, $default_value] = $field_datum
        : [$name, $type] = $field_datum;
        $fields[$name] = newField($name, $type, $default_value);
    }
    return $fields;
}