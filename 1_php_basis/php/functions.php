<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php";

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

    //===================================
    // Show browse happy preamble
    //===================================
    function browseHappy() {
        echo "
            <!--[if lt IE 7]>      <html class='no-js lt-ie9 lt-ie8 lt-ie7'> <![endif]-->
            <!--[if IE 7]>         <html class='no-js lt-ie9 lt-ie8'> <![endif]-->
            <!--[if IE 8]>         <html class='no-js lt-ie9'> <![endif]-->
            <!--[if gt IE 8]>      <html class='no-js'> <![endif]-->
        ";
    }

    //===================================
    // Show outdated browser notification
    //===================================
    function browseHappyNotifier() {
        echo "
            <!--[if lt IE 7]>
                <p class='browsehappy'>You are using an <strong>outdated</strong> browser. Please <a href='#'>upgrade your browser</a> to improve your experience.</p>
            <![endif]-->
        ";
    }

    //===================================
    // Show HTML head element with $title as title
    //===================================
    function head(string $title) {
        echo "
            <head>
                <meta charset='utf-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <title>".ucfirst($title)."</title>
                <meta name='description' content=''>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <link rel='stylesheet' href='/educom-php/1_php_basis/stylesheets/style.css'>
            </head>
        ";
    }

    //===================================
    // Show page navigation
    //===================================
    function navigation() {
        echo '<ul id="nav">';
        foreach (__PAGE_NAMES__ as $page => $page_name) {
            echo '<a href="/educom-php/1_php_basis/?page='.$page.'"><li>'.strtoupper($page_name).'</li></a>';
        }
        echo '</ul>';
    }

    //===================================
    // Show page footer with current year
    //===================================
    function footer() {
        echo "
            <div id='footer'>
                &copy;".date('Y')."Vincent van 't Hof
            </div>
        ";
    }

    //===================================
    // Return HTML for user input as string
    //===================================
    function input(string $input_label, string $input_field, array $errors,): string {
        $result = 
            '<p>'
            .'<label for="'.$input_label.'">'.ucfirst($input_label).':</label>'
            .$input_field
            .'<span class="error">* '.$errors[$input_label].'</span>'
            .'</p>';
        return $result;
    }

    //===================================
    // Return HTML for text input field
    //===================================
    function textInput(string $input_label, array $values, array $errors): string {
        $input_field = '<input type="text" id="'.$input_label.'" name="'.$input_label.'" placeholder="'.ucfirst($input_label).'" value="'.$values[$input_label].'"></input>';
        return input($input_label, $input_field, $errors);
    }

    //===================================
    // Return HTML for textarea input field
    //===================================
    function areaInput(string $input_label, array $values, array $errors): string {
        $input_field = '<textarea id="'.$input_label.'" name="'.$input_label.'" placeholder="'.ucfirst($input_label).'">'.$values[$input_label].'</textarea>';
        return input($input_label, $input_field, $errors);
    }

    //===================================
    // Show page $page_name
    //===================================
    function page(callable $page) {
        head(__PAGE_NAMES__[strval($page)]);
        echo '<body>'; 
        browseHappyNotifier(); 
        navigation(); 
        $page();
        footer();
        echo '</body>';
    }

    //===================================
    // Show Home page content
    //===================================
    function home() {
        echo '
            <h1>Home</h1>
            <p>Welkomstekst!</p>
        '; 
    }

    //===================================
    // Show About page content
    //===================================
    function about() {
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
    function contact() {
        require __ROOT__."/php/message_handler.php";
        echo '<h1>Contact</h1>';
        if (!$valid_message) {
            echo 
                '<p><form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=contact" method="POST">'
                .textInput($name_str, $values, $errors)
                .textInput($email_str, $values, $errors)
                .areaInput($message_str, $values, $errors)
                .'<input type="submit" id="send_button" name="send_button" value="Send">'
                .'</form></p>';
        }
        else {
            foreach ($fields as $field) {
                echo '<p>'.ucfirst($field).': '.$values[$field].'</p>';
            }
            echo '<a href=""><button>Nieuw bericht</button></a>';
        }
    }

    //===================================
    // Load the website
    //===================================
    function init() {
        browseHappy();
        echo '<html>';
        page(in_array($_GET["page"], __PAGES__) ? $_GET["page"] : __HOME__);
        echo '</html>';
    }
?>