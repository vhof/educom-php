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

    $name_str = "name";
    $email_str = "email";
    $message_str = "message";
    $field_names = [$name_str, $email_str, $message_str];

    $field_data = [
        [$name_str, form\TEXTFIELD_CALLABLE],
        [$email_str, form\TEXTFIELD_CALLABLE],
        [$message_str, form\AREAFIELD_CALLABLE],
    ];

    $rules = [
        form\newNonEmptyRule($field_names),
        form\newEmailRule($email_str),
    ];

    form\formPage(FormPage::Contact->value, $field_data, $rules);
}

//===================================
// Show Sign up page content
//===================================
function signUp(): void {
    \import(\Library::Form);

    $name_str = "name";
    $email_str = "email";
    $password_str = "password";
    $confirm_pwd_str = "confirm_password";
    $field_names = [$name_str, $email_str, $password_str, $confirm_pwd_str];

    $field_data = [
        [$name_str, form\TEXTFIELD_CALLABLE],
        [$email_str, form\TEXTFIELD_CALLABLE],
        [$password_str, form\TEXTFIELD_CALLABLE],
        [$confirm_pwd_str, form\TEXTFIELD_CALLABLE],
    ];

    $rules = [
        form\newNonEmptyRule($field_names),
        form\newEqualityRule([$password_str, $confirm_pwd_str]),
    ];

    form\formPage(FormPage::Signup->value, $field_data, $rules);
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

    $rules = [

    ];

    form\formPage(FormPage::Signin->value, $field_data, $rules);
}