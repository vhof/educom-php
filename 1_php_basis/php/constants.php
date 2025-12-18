<?php namespace _1_php_basis;
const LOCAL_ROOT = __ROOT__."/educom-php/1_php_basis";
use const lib\PAGE_KEY;
use const lib\account\SIGNOUT_KEY;

enum Page: string {
    case Home = "home";
    case About = "about";
    case Contact = "contact";
    case Signup = "sign_up";
    case Signin = "sign_in";
    case Signout = "sign_out";

    public static function values(): array {
        return array_map(fn($p) => $p->value, self::cases());
    }

    public static function basePages(): array {
        return [Page::Home, Page::About, Page::Contact];
    }

    public static function sessionPages(): array {
        return [...self::basePages(), Page::Signout];
    }
    
    public static function nonSessionPages(): array {
        return [...self::basePages(), Page::Signup, Page::Signin];
    }

    public static function getPages(array $page_enums): array {
        return array_map(fn($page_enum) => [
            \lib\NAME_KEY => $page_enum->value, 
            \lib\PARAMS_KEY => $page_enum->getPageUrlParams()
        ], $page_enums);
    }

    public static function getPageNames(array $page_enums): array {
        return array_map(fn($page_enum) => $page_enum->value, $page_enums);
    }

    public function getPageUrlParams(): string {
        return match ($this) {
            Page::Signout
                => http_build_query([
                    PAGE_KEY => $_SESSION[PAGE_KEY] ?? "", 
                    SIGNOUT_KEY => true
                ]),
            default
                => http_build_query([
                    PAGE_KEY => $this->value
                ])
        };
    }
}

\defined("__HOME_PAGE__") || define("__HOME_PAGE__", Page::Home);
\defined("__PAGES__") || define("__PAGES__", Page::cases());
\defined("__PAGE_NAMES__") || define("__PAGE_NAMES__", array_map(fn($p) => $p->value, Page::cases()));

const NAME_KEY = "name";
const EMAIL_KEY = "email";
const PASSWORD_KEY = "password";
const CONFIRM_PWD_KEY = "confirm_password";
const MESSAGE_KEY = "message";