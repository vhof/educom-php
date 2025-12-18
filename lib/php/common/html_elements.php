<?php namespace lib;

//===================================
// Show browse happy preamble
//===================================
function browseHappy(): string {
    $result = "
        <!--[if lt IE 7]>      <html class='no-js lt-ie9 lt-ie8 lt-ie7'> <![endif]-->
        <!--[if IE 7]>         <html class='no-js lt-ie9 lt-ie8'> <![endif]-->
        <!--[if IE 8]>         <html class='no-js lt-ie9'> <![endif]-->
        <!--[if gt IE 8]>      <html class='no-js'> <![endif]-->
    ";
    return $result;
}

//===================================
// Show outdated browser notification
//===================================
function browseHappyNotifier(): string {
    $result = "
        <!--[if lt IE 7]>
        <p class='browsehappy'>You are using an <strong>outdated</strong> browser. Please <a href='#'>upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    ";
    return $result;
}

//===================================
// Show HTML head element with $title as title
//===================================
function head(string $title): string {
    $result = "
        <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>".\lib\displayName($title)."</title>
        <meta name='description' content=''>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link rel='stylesheet' href='/educom-php/1_php_basis/stylesheets/style.css'>
        </head>
    ";
    return $result;
}

/**
 * Return page navigation HTML string
 * @param string $base_url Base url to append to hostname
 * @param array<array{
 *      NAME_KEY: string,
 *      PARAMS_KEY: string,
 * }> $pages The names and desired url parameters of every page
 * @return string
 */
function navigation(string $base_url, array $pages): string {
    $result = '<ul id="nav">';
    foreach ($pages as [NAME_KEY => $name, PARAMS_KEY => $params]) 
        $result .= '<a href="'.$base_url.'?'.$params.'"><li>'.strtoupper(displayName($name)).'</li></a>';
    $result .= '</ul>';
    return $result;
}

//===================================
// Show page footer with current year
//===================================
function footer(): string {
    $result = "
        <div id='footer'>
        &copy;".date('Y')."&nbsp;Vincent van 't Hof
        </div>
        ";
    return $result;
}
