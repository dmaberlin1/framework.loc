<?php

namespace PHPFramework;

abstract class Model
{

    public readonly string $table;
    //    разрешенные для записи поля
    public array $fillable = [];
    //    public array $fillable = ['email', 'content'];

    //    поля
    public array $attributes = [];
    public array $rules = [];
    public array $labels = [];

    protected array $errors = [];
    protected array $rules_list = ['required', 'min', 'max', 'email'];
    protected array $messages = [
        'required' => ':fieldname: field is required',
        'min' => ':fieldname: field must be a minimum :rulevalue: characters',
        'max' => ':fieldname: field must be a maximum :rulevalue: characters',
        'email' => ':fieldname: field must be email, example: example@example.example',
    ];

    public function __construct()
    {
        $this->table = static::tableName();
    }

    abstract protected static function tableName(): string;

    public function save():false|string
    {
        // insert into table(`title`,`content`) values(:title,:content)
        //        fields
        $field_keys = array_keys($this->attributes);
        $fields = array_map(fn($field) => "`{$field}`", $field_keys);
        $fields = implode(',', $fields);
        dump($fields);

        //        values
        $values_placeholders = array_map(fn($value) => ":{$value}", $field_keys);
        $values_placeholders = implode(',', $values_placeholders);
        $query = "INSERT INTO {$this->table} ($fields) VALUES ($values_placeholders)";
        db()->query($query, $this->attributes);
        return db()->getInsertId();
        //        dump($query);
        //        dump($values_placeholders);
        //        dump($this->table);
        //        dump($this->attributes);

    }

    public function loadData(): void
    {
        $data = request()->getData();
        foreach ($this->fillable as $field) {
            if (isset($data[$field])) {
                $this->attributes[$field] = $data[$field];
            } else {
                $this->attributes[$field] = '';
            }
        }
    }

    public function validate(): bool
    {
        foreach ($this->attributes as $fieldName => $fieldValue) {
            if (isset($this->rules[$fieldName])) {
                $this->check([
                    'fieldName' => $fieldName,
                    'value' => $fieldValue,
                    'rules' => $this->rules[$fieldName]
                ]);
            }
        }
        return !$this->hasErrors();
    }

    protected function check(array $field): void
    {
        foreach ($field['rules'] as $ruleValidator => $ruleValidator_value) {

            if (in_array($ruleValidator, $this->rules_list, true)) {
                //будет вызываться метод под именем ['required', 'min', 'max', 'email'];
                if (!call_user_func_array([$this, $ruleValidator], [$field['value'], $ruleValidator_value])) {

                    $this->addError(
                        $field['fieldname'],
                        str_replace(
                            [':fieldname:', ':rulevalue:'],
                            [$this->labels[$field['fieldname']] ?? $field['fieldname'], $ruleValidator_value],
                            $this->messages[$ruleValidator]
                        )
                    );
                }

            }
        }
    }

    protected function addError($fieldname, $error): void
    {
        $this->errors[$fieldname][] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function hasErrors()
    {
        //        если есть ошибки, вернут тру
        return !empty($this->errors);
    }

    public function listErrors():string
    {
        $output='<ul class="list-unstyled">';
        foreach ($this->errors as $field_errors){
            foreach ($field_errors as $error){
                $output.="<li>{$error}</li>";
            }
        }
        $output.='</ul>';
        return $output;
    }

    protected function required($value, $rule_value): bool
    {
        return (trim($value) == true);
    }

    protected function min($value, $rule_value): bool
    {
        return mb_strlen($value, 'UTF-8') >= $rule_value;
    }

    protected function max($value, $rule_value): bool
    {
        return mb_strlen($value, 'UTF-8') <= $rule_value;
    }

    protected function email($value, $rule_value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }


}