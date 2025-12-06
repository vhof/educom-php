<?php require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php" ?>
<?php 


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

        public function testCondition(array $values, string ...$field_names): bool {
            return $this->condition->call($this, $values, ...$field_names);
        }

        public function getAppliesTo(): array {
            return $this->applies_to;
        }

        public function getErrorMsg(): string {
            return $this->error_msg;
        }

        public static function nonEmpty(array $applies_to): FormRule {
            $condition = function (array $values, string $field): bool {
                return !isEmpty($values[$field]);
            };
            return new FormRule($applies_to, $condition, "Required field");
        }

        public static function equal(array $applies_to, string $compare_to): FormRule {
            $condition = function (array $values, string $field) use ($compare_to): bool {
                return $values[$field] == $values[$compare_to];
            };
            return new FormRule($applies_to, $condition, ucfirst($compare_to)." fields must be equal");
        }

        public static function validEmail(array $applies_to): FormRule {
            $condition = function (array $values, string $field): bool {
                return filter_var($values[$field], FILTER_VALIDATE_EMAIL);
            };
            return new FormRule($applies_to, $condition, "Not a valid E-mailaddress");
        }
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
            foreach ($this->fields as $field) {
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
                    foreach ($rule->getAppliesTo() as $field) {
                        if (!$rule->testCondition($this->values, $field)) {
                            $this->errors[$field] = $rule->getErrorMsg();
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

        public function getValue(string $field): string {
            return $this->values[$field];
        }

        public function getError(string $field): string {
            return $this->errors[$field];
        }

        public function isValid(): bool {
            $this->validate();
            return $this->is_valid;
        }

    }

    abstract class FieldModel {
        protected string $name;

        public function __construct(string $name) {
            $this->name = $name;
        }

        public function printField(string $value, string $error): void {
            $result = 
                '<p>'
                .'<label for="'.$this->name.'">'.ucfirst($this->name).':</label>'
                .$this->createField($value)
                .'<span class="error">* '.$error.'</span>'
                .'</p>';
            echo $result;
        }

        abstract public function createField(string $value): string;
    }

    class TextFieldModel extends FieldModel {
        protected string $name;
        
        public function createField(string $value): string {
            return '<input type="text" id="'.$this->name.'" name="'.$this->name.'" placeholder="'.ucfirst($this->name).'" value="'.$value.'"></input>';
        }
    }

    class AreaFieldModel extends FieldModel {
        public function createField(string $value): string {
            return '<textarea id="'.$this->name.'" name="'.$this->name.'" placeholder="'.ucfirst($this->name).'">'.$value.'</textarea>';
        }
    }

    class FormModel {

    }

?>