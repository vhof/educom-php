<?php
defined("__ROOT__") || define("__ROOT__", $_SERVER["DOCUMENT_ROOT"]);

enum Library: string {
    case Common = __ROOT__."/educom-php/lib/php/common";
    case Form = __ROOT__."/educom-php/lib/php/form";
}

/**
 * Use require_once on .php file(s) located at $path. Works for whole directory or single file strings. Use Library case for predefined locations. 
 * @param string|Library $path directory or file path, or Library
 * @return void
 */
function import(string|Library $path): void{
    $path = $path instanceof Library ? $path->value : $path;
    $is_dir = is_dir($path);
    $files = $is_dir ? scandir($path) : [$path];
    $files = array_filter($files, fn($file) => substr($file, -4) == ".php");
    foreach ($files as $file) {
        $file_path = ($is_dir ? $path . "/" : "") . $file;
        require_once $file_path;
        echo $file_path;
    }
}