<?php 
    namespace lib{
        //===================================
        // Show page navigation
        //===================================
        function navigation(string $page_enum) {
            echo '<ul id="nav">';
            $pages = $page_enum::cases();
            foreach ($pages as $page) {
                echo '<a href="/educom-php/1_php_basis/?page='.$page->value.'"><li>'.strtoupper(displayName($page->value)).'</li></a>';
            }
            echo '</ul>';
        }

        //===================================
        // Return true if $value is unset or an empty string
        //===================================
        function isEmpty(string $value) {
            return !isset($value) || $value === "";
        }

        //===================================
        // Return $data without leading or trailing whitespace, backslashes, or special HTML chars
        //===================================
        function cleanInput(string $data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function displayName($str): string {
            return str_replace("_", " ", $str);
        }

        function callableFromName(string $str): string {
            return lcfirst(str_replace("_","",ucwords($str,"_")));
        }
    }

    namespace chapter1 {
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

        defined("__PAGES__") || define("__PAGES__", Page::cases());
        defined("__PAGE_NAMES__") || define("__PAGE_NAMES__", Page::values());
        
        require_once __ROOT__."/php/functions.php";
    }
?>