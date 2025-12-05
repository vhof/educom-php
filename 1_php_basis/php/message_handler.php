<?php require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php" ?>
<?php 
    $valid_message = false;
    $name_str = "name";
    $email_str = "email";
    $message_str = "message";
    $fields = array($name_str, $email_str, $message_str);
    $values = array($name_str => "", $email_str => "", $message_str => "");
    $errors = array($name_str => "", $email_str => "", $message_str => "");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $valid_message = true;

        foreach ($fields as $field) {
            $values[$field] = cleanInput($_POST[$field]);
        }

        // Validate email
        if (!filter_var($values[$email_str], FILTER_VALIDATE_EMAIL)) {
            $errors[$email_str] = "Invalid email format";
            $valid_message = false;
        }

        // Check empty fields
        foreach ($fields as $field) {
            if (isEmpty($values[$field])) {
                $errors[$field] = "Required field";
                $valid_message = false;
            }
        }
    }

    class FormRule {
        private array $applies_to;
        private Closure $condition;
        private string $error_msg;

        public function __construct(array $applies_to, callable $condition, string $error_msg) {
            $this->applies_to = $applies_to;
            $reflection = new ReflectionFunction($condition);
            if ($reflection->getReturnType() == "bool"){
                $this->condition = Closure::fromCallable($condition);
            }
            else {
                throw new InvalidArgumentException("Callback function must have return type bool");
            }
            $this->error_msg = $error_msg;
        }

        public function testCondition(array $values, string $field_name): bool {
            return $this->condition->call($this, $values, $field_name);
        }

        public function getAppliesTo(): array {
            return $this->applies_to;
        }

        public function getErrorMsg(): string {
            return $this->error_msg;
        }

        // // Validate email
        // if (!filter_var($this->values[$email_str], FILTER_VALIDATE_EMAIL)) {
        //     $this->errors[$email_str] = "Invalid email format";
        //     $this->is_valid = false;
        // }

        // // Check empty fields
        // foreach ($this->fields as $field) {
        //     if (isEmpty($this->values[$field])) {
        //         $this->errors[$field] = "Required field";
        //         $this->is_valid = false;
        //     }
        // }
    }

    class RuleSet implements Iterator {
        private $items = [];
        private $pointer = 0;

        public function __construct(...$items) {
            $this->items = $items;
        }

        public function push(FormRule $rule) {
            throw new Exception("Not implemented yet");
        }

        public function key(): int {
            return $this->pointer;
        }

        public function current(): FormRule {
            return $this->items[$this->pointer];
        }

        public function next(): void {
            $this->pointer++;
        }

        public function rewind(): void {
            $this->pointer = 0;
        }

        public function valid(): bool {
            return $this->pointer < count($this->items);
        }
    }

    class FormValidator {
        private array $fields;
        private RuleSet $rules;
        private array $values;
        private array $input_transformations;
        private array $errors;
        private bool $is_valid;

        public function __construct(array $fields, RuleSet $rules){
            $this->fields = $fields;
            $this->rules = $rules;
            foreach ($this->$fields as $field) {
                $this->values[$field] = $this->errors[$field] = "";
            }
            $this->is_valid = false;
        }

        private function validate() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->is_valid = true;

                foreach ($this->fields as $field) {
                    $this->values[$field] = cleanInput($_POST[$field]);
                }

                foreach ($this->rules as $rule) {
                    foreach ($rule->getAppliesTo() as $field_name) {
                        if (!$rule->testCondition($this->values, $field_name)) {
                            $this->errors[$field_name] = $rule->getErrorMsg();
                            $this->is_valid = false;
                        }
                    }
                }
            }
        }

        public function getFields(): array {
            return $this->fields;
        }

        public function getValues(): array {
            return $this->values;
        }

        public function getErrors(): array {
            return $this->errors;
        }

        public function isValid(): bool {
            $this->validate();
            return $this->is_valid;
        }

    }


?>