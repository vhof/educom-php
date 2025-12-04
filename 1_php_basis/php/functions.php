<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php";
    //===================================
    // Return true if $value is unset or an empty string
    //===================================
    function isEmpty($value) {
        return !isset($value) || $value === "";
    }

    //===================================
    // Return $data without leading or trailing whitespace, backslashes, or special HTML chars
    //===================================
    function cleanInput($data) {
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
    function head($title) {
        echo "
            <head>
                <meta charset='utf-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <title>".$title."</title>
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
        echo "
            <ul id='nav'>
                <a href='/educom-php/1_php_basis/'><li>HOME</li></a>
                <a href='/educom-php/1_php_basis/?page=about'><li>ABOUT</li></a>
                <a href='/educom-php/1_php_basis/?page=contact'><li>CONTACT</li></a>
            </ul>
        ";
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
    // Show page $page_name
    //===================================
    function page($page_name) {
        head(ucfirst($page_name));
        echo '<body>'; 
        browseHappyNotifier(); 
        navigation(); 
        $page_name();
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
            echo '
                <p>
                    <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=contact" method="POST">
                        <label for="name">Naam:</label>
                        <input type="text" id="name" name="name" placeholder="Naam" value="'.$values[$name_str].'"></input>
                        <span class="error">* '.$error[$name_str].'</span>
                        <br>
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" placeholder="Email" value="'.$values[$email_str].'"></input>
                        <span class="error">* '.$error[$email_str].'</span>
                        <br>
                        <label for="message">Bericht:</label>
                        <textarea id="message" name="message" placeholder="Bericht" rows="6">'.$values[$message_str].'</textarea>
                        <span class="error">* '.$error[$message_str].'</span>
                        <br>
                        <input type="submit" id="send_button" name="send_button" value="Verstuur">
                    </form>
                </p>
            ';
        }
        else {
            echo '
                <p>Naam: '.$values["name"].'</p>
                <p>Email: '.$values["email"].'</p>
                <p>Bericht: '.$values["message"].'</p>
                <a href=""><button>Nieuw bericht</button></a>
            ';
        }
    }
?>