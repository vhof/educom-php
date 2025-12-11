<?php namespace _1_php_basis;
defined("__ROOT__") || define("__ROOT__", $_SERVER["DOCUMENT_ROOT"]."/educom-php/1_php_basis");

enum Page: string {
    case Home = "home";
    case About = "about";
    case Contact = "contact";
    case Signup = "sign_up";
    case Signin = "sign_in";

    public static function values(): array {
        return array_map(fn($p) => $p->value, self::cases());
    }
}

enum FormPage: string {
    case Contact = Page::Contact->value;
    case Signup = Page::Signup->value;
    case Signin = Page::Signin->value;
}

defined("__HOME_PAGE__") || define("__HOME_PAGE__", Page::Home);
defined("__PAGES__") || define("__PAGES__", Page::cases());
defined("__PAGE_NAMES__") || define("__PAGE_NAMES__", array_map(fn($p) => $p->value, Page::cases()));