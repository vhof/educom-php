<?php 
    namespace chapter1;
    require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php";

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
    // Show page footer with current year
    //===================================
    function footer() {
        echo "
            <div id='footer'>
                &copy;".date('Y')."Vincent van 't Hof
            </div>
        ";
    }

    function newField (string $name, string $value, callable $type, ?string $placeholder = null) {
        return [
            "name" => $name, 
            "value" => $value,
            "type" => $type,
            "rules" => [],
            "error_msg" => "",
            "placeholder" => $placeholder ?? ucfirst($name),
        ];
    }

    //===================================
    // Return HTML for user input as string
    //===================================
    function field(string $input_label, string $input_field, array $errors,): string {
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
    function textField(string $input_label, array $values, array $errors): string {
        $input_field = '<input type="text" id="'.$input_label.'" name="'.$input_label.'" placeholder="'.ucfirst($input_label).'" value="'.$values[$input_label].'"></input>';
        return field($input_label, $input_field, $errors);
    }

    //===================================
    // Return HTML for textarea input field
    //===================================
    function areaField(string $input_label, array $values, array $errors): string {
        $input_field = '<textarea id="'.$input_label.'" name="'.$input_label.'" placeholder="'.ucfirst($input_label).'">'.$values[$input_label].'</textarea>';
        return field($input_label, $input_field, $errors);
    }

    //===================================
    // Show page $page
    //===================================
    function loadPage(Page $page) {
        head($page->value);
        echo '<body>'; 
        browseHappyNotifier(); 
        \lib\navigation(Page::class); 
        $pageCallable = __NAMESPACE__.'\\'.\lib\callableFromName($page->value);
        $pageCallable();
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

/**
     * @param array<array{
     *      name: string, 
     *      value: string,
     *      type: callable,
     *      rules: array<callable>,
     *      error_msg: string,
     *      "placeholder"?: string,
     * }>  $fields
     * 
     * @return null Show a Form page based on $form_page
     */
    function formModel(FormPage $form_page, array $fields) {
        $action_url = htmlspecialchars($_SERVER["PHP_SELF"]."?page=".$form_page->value);
        $result = "<p><form action='$action_url' method='POST'>";
        $fieldCallable = null;
        foreach ($fields as $field) {
            $fieldCallable = $field["type"];
            $result .= $fieldCallable($field);
        }
        $result .= 
            "<input type='submit' id='send_button' name='send_button' value='Send'>"
            ."</form></p>";
    }

    /**
     * @param array{
     *      name: string, 
     *      value: string,
     *      type: callable,
     *      rules: array<callable>,
     *      error_msg: string,
     *      "placeholder"?: string,
     * }  $fields
     * 
     * Show a Form page based on $form_page
     */
    function formPage(FormPage $form_page, array $fields) {

    }

    // formPage("a", )

    //===================================
    // Show Contact page content
    //===================================
    function contact() {
        require __ROOT__."/php/message_handler.php";
        $name_str = "name";
        $email_str = "email";
        $message_str = "message";
        $field_names = array($name_str, $email_str, $message_str);

        $name_field = newField($name_str, "", "textField");
        $email_field = newField($email_str, "", "textField");
        $message_field = newField($message_str, "", "areaField");
        $fields = [$name_field, $email_field, $message_field];

        echo '<h1>Contact</h1>';
        if (!$is_valid) {
            echo formModel(FormPage::Contact, $fields);
        }
        // else {
        //     foreach ($fields as $field) {
        //         echo '<p>'.ucfirst($field).': '.$values[$field].'</p>';
        //     }
        //     echo '<a href=""><button>Nieuw bericht</button></a>';
        // }
    }

    //===================================
    // Load the website
    //===================================
    function init() {
        browseHappy();
        echo '<html>';
        loadPage(Page::tryFrom($_GET["page"]) ?? Page::Home);
        echo '</html>';
    }
?>