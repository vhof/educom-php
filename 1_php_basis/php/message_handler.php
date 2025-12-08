<?php require_once $_SERVER['DOCUMENT_ROOT']."/educom-php/1_php_basis/php/constants.php" ?>
<?php 

    enum InputErrorType {
        case NonEmpty;
        case Email;
        case Equality;
        
        public function precedence(): int {
            return match($this) {
                self::NonEmpty => 0,
                self::Email => 1,
                self::Equality => 2,
            };
        }
    }

    class InputError {
        public function __construct(public InputErrorType $type, public string $message = "error") {}

        public function precedence(): int {
            return $this->type->precedence();
        }

        public static function nonEmpty(): static { 
            return new static(InputErrorType::NonEmpty, "Required field"); 
        }
        public static function email(): static {
             return new static(InputErrorType::Email, "Not a valid E-mailaddress"); 
        }
        public static function equality(string $compare_to): static {
             return new static(InputErrorType::Equality, ucfirst($compare_to)." fields must be equal"); 
        }
    }

    class InputErrors {
        private array $input_errors = [];

        public function __construct(InputError ...$input_errors){
            $this->input_errors = $input_errors;
            $this->sort();
        }

        public function append(InputError $input_error): void {
            $this->input_errors[] = $input_error;
            $this->sort();
        }

        public function getErrorMsg(): string {
            return $this->input_errors[0] ?? "";
        }

        private function sort(): void {
            usort($this->input_errors, fn($a, $b) => $a->precedence() <=> $b->precedence());
        }
    }

    class FormRule {
        private array $applies_to;
        private Closure $condition;
        private InputError $input_error;

        public function __construct(array $applies_to, callable $condition, InputError $input_error) {
            $this->applies_to = $applies_to;
            $reflection = new ReflectionFunction($condition);
            if ($reflection->getReturnType() == "bool"){
                $this->condition = Closure::fromCallable($condition);
            }
            else {
                throw new InvalidArgumentException("Callback function must have return type bool");
            }
            $this->input_error = $input_error;
        }

        public function testCondition(array $values, string ...$field_names): bool {
            return $this->condition->call($this, $values, ...$field_names);
        }

        public function getAppliesTo(): array {
            return $this->applies_to;
        }

        public function getErrorMsg(): string {
            return $this->input_error->message;
        }

        public static function nonEmpty(array $applies_to): static {
            $condition = function (array $values, string $field): bool {
                return !isEmpty($values[$field]);
            };
            return new static($applies_to, $condition, InputError::nonEmpty());
        }

        public static function equal(array $applies_to, string $compare_to): static {
            $condition = function (array $values, string $field) use ($compare_to): bool {
                return $values[$field] == $values[$compare_to];
            };
            return new static($applies_to, $condition, InputError::equality($compare_to));
        }

        public static function email(array $applies_to): static {
            $condition = function (array $values, string $field): bool {
                return filter_var($values[$field], FILTER_VALIDATE_EMAIL);
            };
            return new static($applies_to, $condition, InputError::email());
        }
    }

    /** 
     * @template T 
     * @implements IteratorAggregate<int, T>
     */
    abstract class TypedCollection implements IteratorAggregate {
        protected array $array = [];

        public function getIterator(): ArrayIterator {
            return new ArrayIterator($this->array);
        }
    }

    /** @extends TypedCollection<FormRule> */
    class RuleSet extends TypedCollection {
        public function __construct(FormRule ...$items) {
            $this->array = $items;
        }
    }

    /** @extends TypedCollection<Field> */
    class FieldSet extends TypedCollection {
        public function __construct(Field ...$items) {
            $this->array = $items;
        }
    }

    class FormValidator {
        private FieldSet $fields;
        private RuleSet $rules;
        private array $values;
        private array $input_transformations;
        private array $errors;
        private bool $is_valid;

        public function __construct(FieldSet $fields, RuleSet $rules){
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

        public function getFields(): FieldSet {
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

    enum FieldType {
        case Text;
        case Area;

        public function getModel() {
            return match($this) {
                self::Text => TextFieldModel::class,
                self::Area => AreaFieldModel::class
            };
        }
    }

    class Field { 
        public string $placeholder;
        public InputErrors $input_errors;

        public function __construct(public string $name, public FieldType $field_type, public string $value = "", ?string $placeholder = null) {
            $this->placeholder = $placeholder ?? ucfirst($name);
            $this->input_errors = new InputErrors();
        }

        public function logError(InputError $input_error): void {
            $this->input_errors->append($input_error);
        }

        public function draw(): void {
            $this->field_type->getModel()::draw($this);
        }
    }

    abstract class FieldModel {
        public static function draw(Field $field): void {
            $result = 
                '<p>'
                .'<label for="'.$field->name.'">'.ucfirst($field->name).':</label>'
                .self::drawInput($field)
                .'<span class="error">* '.$field->input_errors->getErrorMsg().'</span>'
                .'</p>';
            echo $result;
        }

        abstract protected static function drawInput(Field $field): string;
    }

    class TextFieldModel extends FieldModel {        
        protected static function drawInput(Field $field): string {
            return "<input 
                type='text' 
                id='$field->name' 
                name='$field->name' 
                placeholder='$field->placeholder' 
                value='$field->value'>
            </input>";
        }
    }

    class AreaFieldModel extends FieldModel {
        protected static function drawInput(Field $field): string {
            return "<textarea 
                id='$field->name' 
                name='$field->name' 
                placeholder='$field->placeholder'>
                '$field->value'
            </textarea>";
        }
    }

    class FormModel {
        private FieldSet $fields; //type: FormModel TODO: change to FieldSet (implement FieldSet)
        private FormValidator $validator;

        public function __construct(FieldSet $fields, private RuleSet $rules) {
            $this->fields = $fields;
            $this->validator = new FormValidator($this->fields, $this->rules);
        }

        public function draw(): void {
            $is_valid = $this->validator->isValid();

            if (!$is_valid) {
                echo '<p><form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page='.__CONTACT__.'" method="POST">';
                foreach ($this->fields as $field) {
                    $field->draw();
                }
                echo '<input type="submit" id="send_button" name="send_button" value="Send">';
                echo '</form></p>';
            }
            else {
                foreach ($this->fields as $field) {
                    echo '<p>'.ucfirst($field->name).': '.$field->value.'</p>';
                }
                echo '<a href=""><button>Nieuw bericht</button></a>';
            }
        }
    }

?>