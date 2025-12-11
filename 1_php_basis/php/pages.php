<?php namespace _1_php_basis;
use lib\form;

//===================================
// Show Home page content
//===================================
function home(): void {
    echo '
        <h1>Home</h1>
        <p>Welkomstekst!</p>
    '; 
}

//===================================
// Show About page content
//===================================
function about(): void {
    echo '
        <h1>About</h1>
        <h2>Wie ben ik?</h2>
        <p>Ik ben Vincent!</p>
        <h2>Wat doe ik?</h2>
        <p>Naast mijn hobbies, Gamen, Zwemmen, Boulderen, Skiën, D&D, Rock & Metal Concerten bezoeken en Homelabbing, vind ik het ook leuk om te programmeren. Vandaar deze website, om te oefenen!</p>
    '; 
}

//===================================
// Show Contact page content
//===================================
function contact(): void {
    \import(\Library::Form);

    $field_data = [
        ["name", form\TEXTFIELD_CALLABLE],
        ["email", form\TEXTFIELD_CALLABLE],
        ["message", form\AREAFIELD_CALLABLE],
    ];

    $fields = form\newFields($field_data);

    form\formPage(FormPage::Contact->value, $fields);
}

//===================================
// Show Sign up page content
//===================================
function signUp(): void {
    \import(\Library::Form);

    $field_data = [
        ["email", form\TEXTFIELD_CALLABLE],
        ["password", form\TEXTFIELD_CALLABLE],
        ["confirm_password", form\TEXTFIELD_CALLABLE],
    ];

    $fields = form\newFields($field_data);

    form\formPage(FormPage::Signup->value, $fields);
}

//===================================
// Show Sign in page content
//===================================
function signIn(): void {
    \import(\Library::Form);

    $field_data = [
        ["email", form\TEXTFIELD_CALLABLE],
        ["password", form\TEXTFIELD_CALLABLE],
    ];

    $fields = form\newFields($field_data);

    form\formPage(FormPage::Signin->value, $fields);
}