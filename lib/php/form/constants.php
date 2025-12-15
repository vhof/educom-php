<?php namespace lib\form;

const NS = __NAMESPACE__.'\\';

// Array keys //
const IS_VALID_KEY = "is_valid";
// Field
const NAME_KEY = "name";
const VALUE_KEY = "value";
const TYPE_KEY = "type";
const ERRORS_KEY = "errors";
const PLACEHOLDER_KEY = "placeholder";

//Rule
const RULE_CALLABLE_KEY = "rule_callable";
const APPLIES_TO_KEY = "applies_to";
const ERROR_KEY = "error";

// Form
const FIELDS_KEY = "fields";
const RULES_KEY = "rules";
const ACTION_KEY = "action_url";

// Standard input field types
const TEXTFIELD_CALLABLE = NS."textFieldModel";
const AREAFIELD_CALLABLE = NS."areaFieldModel";

// Standard rule callables
const NONEMPTY_RULE_CALLABLE = NS."nonEmptyRule";
const EMAIL_RULE_CALLABLE = NS."emailRule";
const EQUALITY_RULE_CALLABLE = NS."equalityRule";

const PRECEDENCE_KEY = "precedence";
const ERROR_MSG_KEY = "message";

const NONEMPTY_ERROR = [
    PRECEDENCE_KEY => 0,
    ERROR_MSG_KEY => "Required field",
];
const EMAIL_ERROR = [
    PRECEDENCE_KEY => 1,
    ERROR_MSG_KEY => "Not a valid email address",
];
const EQUALITY_ERROR = [
    PRECEDENCE_KEY => 2,
    ERROR_MSG_KEY => "Fields must be equal",
];