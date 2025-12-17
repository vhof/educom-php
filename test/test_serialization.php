<?php
require_once "C:/xampp/htdocs/educom-php/importer.php";
\import('C:\xampp\htdocs\educom-php\lib\php\common');
\import('C:\xampp\htdocs\educom-php\lib\php\account');
use lib\account;

$test_data = "vincent@test.nl|vincent|123";

$test_unserialized = account\unserializeUser($test_data);

echo var_dump($test_unserialized);