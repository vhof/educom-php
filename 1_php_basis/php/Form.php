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
        public function __construct(
            public readonly InputErrorType $type, 
            public readonly string $message = "error"
        ) {}

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
            return $this->input_errors ? $this->input_errors[0]->message : "";
        }

        private function sort(): void {
            usort($this->input_errors, fn($a, $b) => $a->precedence() <=> $b->precedence());
        }
    }

    class FormRule {
        private Closure $condition;

        public function __construct(
            public readonly array $applies_to, 
            callable $condition, 
            public readonly InputError $input_error
        ) {
            $reflection = new ReflectionFunction($condition);
            if ($reflection->getReturnType() == "bool"){
                $this->condition = Closure::fromCallable($condition);
            }
            else {
                throw new InvalidArgumentException(__CLASS__.": Callback function must have return type bool");
            }
        }

        public function testCondition(array $values, string ...$field_names): bool {
            return $this->condition->call($this, $values, ...$field_names);
        }

        public function getError(): InputError {
            return $this->input_error;
        }

        public static function nonEmpty(array $applies_to): static {
            $condition = function (array $values, string $field_name): bool {
                return !isEmpty($values[$field_name]);
            };
            return new static($applies_to, $condition, InputError::nonEmpty());
        }

        public static function equal(array $applies_to, string $compare_to): static {
            $condition = function (array $values, string $field_name) use ($compare_to): bool {
                return $values[$field_name] == $values[$compare_to];
            };
            return new static($applies_to, $condition, InputError::equality($compare_to));
        }

        public static function email(array $applies_to): static {
            $condition = function (array $values, string $field_name): bool {
                return filter_var($values[$field_name], FILTER_VALIDATE_EMAIL);
            };
            return new static($applies_to, $condition, InputError::email());
        }
    }

    /** 
     * @template T 
     * @implements IteratorAggregate<int|string, T>
     * @implements ArrayAccess<int|string, T>
     */
    abstract class TypedCollection implements IteratorAggregate, ArrayAccess {
        protected array $array = [];
        /** @property class-string<T> */
        protected string $type;

        public function getIterator(): ArrayIterator {
            return new ArrayIterator($this->array);
        }

        protected function validateType(mixed $value): void {
            if (!$value instanceof $this->type) {
                throw new InvalidArgumentException("Value must be $this->type");
            }
        }

        public function offsetSet($offset, $value): void {
            $this->validateType($value);

            if (is_null($offset)) {
                $this->array[] = $value;
            } else {
                $this->array[$offset] = $value;
            }
        }

        public function offsetExists($offset): bool {
            return isset($this->array[$offset]);
        }

        public function offsetUnset($offset): void {
            unset($this->array[$offset]);
        }

        public function offsetGet($offset): mixed {
            return isset($this->array[$offset]) ? $this->array[$offset] : null;
        }
    }

    /** @extends TypedCollection<FormRule> */
    class RuleSet extends TypedCollection {
        public function __construct(FormRule ...$items) {
            $this->type = FormRule::class;
            $this->array = $items;
        }
    }

    /** @extends TypedCollection<Field> */
    class FieldSet extends TypedCollection {
        public function __construct(Field ...$fields) {
            $this->type = Field::class;
            foreach ($fields as $field) {
                $this->array[$field->name] = $field;
            }
        }

        public function getValues(): array {
            $values = [];
            foreach ($this as $field) {
                $values[$field->name] = $field->value;
            }
            
            return $values;
        }
    }

    class FormValidator {
        private bool $is_valid = false;

        public function __construct(private Form $form) {}

        private function validate() {
            $values = $this->form->fields->getValues();
            $this->is_valid = true;

            foreach ($this->form->rules as $rule) {
                foreach ($rule->applies_to as $field_name) {
                    if (!$rule->testCondition($values, $field_name)) {
                        $this->form->fields[$field_name]->logError($rule->input_error);
                        $this->is_valid = false;
                    }
                }
            }
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
                self::Text => new TextFieldModel(),
                self::Area => new AreaFieldModel()
            };
        }
    }

    abstract class FieldModel {
        public function draw(Field $field): void {
            $result = 
                '<p>'
                .'<label for="'.$field->name.'">'.ucfirst($field->name).':</label>'
                .$this->drawInput($field)
                .'<span class="error">* '.$field->getErrorMsg().'</span>'
                .'</p>';
            echo $result;
        }

        abstract protected function drawInput(Field $field): string;
    }

    class TextFieldModel extends FieldModel {        
        protected function drawInput(Field $field): string {
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
        protected function drawInput(Field $field): string {
            return "<textarea 
                id='$field->name' 
                name='$field->name' 
                placeholder='$field->placeholder'>".$field->value."</textarea>";
        }
    }

    class FormModel {
        public static function draw(Form $form): void {
            echo '<p><form action="'.$form->action_url.'" method="POST">';
            foreach ($form->fields as $field) {
                $field->draw();
            }
            echo '<input type="submit" id="send_button" name="send_button" value="Send">';
            echo '</form></p>';
        }

        public static function drawResults(Form $form): void {
            foreach ($form->fields as $field) {
                echo '<p>'.ucfirst($field->name).': '.$field->value.'</p>';
            }
            echo '<a href=""><button>Nieuw bericht</button></a>';
        }
    }

    class Field { 
        public string $placeholder;
        public InputErrors $input_errors;

        public function __construct(
            public readonly string $name, 
            public readonly FieldType $field_type, 
            public string $value = "", 
            ?string $placeholder = null
        ) {
            $this->placeholder = $placeholder ?? ucfirst($name);
            $this->input_errors = new InputErrors();
        }

        public function logError(InputError $input_error): void {
            $this->input_errors->append($input_error);
        }

        public function getErrorMsg(): string {
            return $this->input_errors->getErrorMsg();
        }

        public function draw(): void {
            $this->field_type->getModel()->draw($this);
        }
    }

    class Form {
        private FormValidator $validator;
        public readonly string $action_url;

        public function __construct(
            public readonly FieldSet $fields, 
            public readonly RuleSet $rules,
            string $action_page
        ) {
            $this->validator = new FormValidator($this);
            $this->action_url = htmlspecialchars($_SERVER["PHP_SELF"].'?page='.$action_page);
        }

        public function draw(): void {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                foreach ($this->fields as $field) {
                        $field->value = cleanInput($_POST[$field->name]);
                    }
            }

            $is_valid = $this->validator->isValid();

            if (!$is_valid) {
                FormModel::draw($this);
            }
            else {
                FormModel::drawResults($this);
            }
        }
    }

?>