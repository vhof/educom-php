<?php namespace _1_php_basis;
use Library;
use lib\form;
use lib\account;

//===================================
// Show Home page content
//===================================
function home(): void {
    $user_name = account\getSignedUserName();
    echo '<h1>Home</h1>'
        .'<p>';
    if (account\signedIn() && !\lib\isEmpty($user_name))
        echo 'Welkom '.$user_name.'!';
    else
        echo 'Welkomstekst!'; 
    echo '</p>';
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

function formPage(Page $page, array $field_data, array $rules, string $submit_text, string $error_msg): void {
    form\loadForm($page->value, \lib\responseCallableFromName($page->value, __NAMESPACE__), $field_data, $rules, $submit_text, $error_msg);
}

//===================================
// Show Contact page content
//===================================
function contact(string $error_msg = ""): void {
    \import(Library::Form);

    $field_keys = [NAME_KEY, EMAIL_KEY, MESSAGE_KEY];

    $default_name = account\getSignedUserName();
    $default_email = account\getSignedUserEmail();

    $field_data = [
        [NAME_KEY   , form\TEXTFIELD_CALLABLE, $default_name    ],
        [EMAIL_KEY  , form\TEXTFIELD_CALLABLE, $default_email   ],
        [MESSAGE_KEY, form\AREAFIELD_CALLABLE                   ],
    ];

    $rules = [
        form\newNonEmptyRule(...$field_keys),
        form\newEmailRule(EMAIL_KEY),
    ];

    formPage(Page::Contact, $field_data, $rules, "Send message", $error_msg);
}

//===================================
// Show Sign up page content
//===================================
function signUp(string $error_msg = ""): void {
    \import(Library::Form);

    $field_keys = [NAME_KEY, EMAIL_KEY, PASSWORD_KEY, CONFIRM_PWD_KEY];

    $field_data = [
        [NAME_KEY       , form\TEXTFIELD_CALLABLE],
        [EMAIL_KEY      , form\TEXTFIELD_CALLABLE],
        [PASSWORD_KEY   , form\TEXTFIELD_CALLABLE],
        [CONFIRM_PWD_KEY, form\TEXTFIELD_CALLABLE],
    ];

    $rules = [
        form\newNonEmptyRule(EMAIL_KEY, PASSWORD_KEY, CONFIRM_PWD_KEY),
        form\newEmailRule(EMAIL_KEY),
        form\newEqualityRule(PASSWORD_KEY, CONFIRM_PWD_KEY),
    ];

    formPage(Page::Signup, $field_data, $rules, \lib\displayName(Page::Signup->value), $error_msg);
}

//===================================
// Show Sign in page content
//===================================
function signIn(string $error_msg = ""): void {
    \import(Library::Form);

    $field_keys = [EMAIL_KEY, PASSWORD_KEY];

    $field_data = [
        [EMAIL_KEY      , form\TEXTFIELD_CALLABLE],
        [PASSWORD_KEY   , form\TEXTFIELD_CALLABLE],
    ];

    $rules = [
        form\newNonEmptyRule(...$field_keys),
        form\newEmailRule(EMAIL_KEY),
    ];

    formPage(Page::Signin, $field_data, $rules, \lib\displayName(Page::Signin->value), $error_msg);
}

function signOut(): void {
    \import(Library::Account);

    account\signOut();
}

function contactResponse(array &$form): void {
    foreach ($form[form\FIELDS_KEY] as $field) 
        echo '<p>'.\lib\displayName($field[form\NAME_KEY]).': '.$field[form\VALUE_KEY].'</p>';
    echo '<a href=""><button>New message</button></a>';
}

function signUpResponse(array &$form): void {
    \import(Library::Account);

    [   EMAIL_KEY       => $email,
        NAME_KEY        => $name,
        PASSWORD_KEY    => $pwd,
    ] = form\getValues($form);

    $user = account\signUp($email, $name, $pwd);

    if ($user) 
        signInResponse($form);
    else 
        signUp("Email is already taken");
}

function signInResponse(array &$form): void {
    \import(Library::Account);

    [   EMAIL_KEY       => $email,
        PASSWORD_KEY    => $pwd,
    ] = form\getValues($form);

    $sign_in = account\signIn($email, $pwd);

    if ($sign_in instanceof account\SignInError)
        signIn($sign_in->getErrorMsg());
    elseif (!$sign_in)
        signIn("Sign in failed for unkown reason");
    else {
        loadPage(__HOME_PAGE__->value);
    }
}