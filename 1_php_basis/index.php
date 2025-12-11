<!DOCTYPE html>
<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/importer.php";
    \import(\Library::Common);
    \import(getcwd().'/php');
    $namespace = '_'.basename(__DIR__);
    $init = "\\$namespace\\init";
    $init(); 
?>