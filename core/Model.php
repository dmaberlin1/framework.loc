<?php

namespace PHPFramework;

abstract class Model
{
    //    разрешенные для записи поля
    public array $fillable = [];
    //    public array $fillable = ['email', 'content'];

    //    поля
    public array $attributes = [];
    public array $rules = [];

    protected array $errors = [];
    protected array $rules_list = ['required', 'min', 'max', 'email'];
    protected array $messages = [
        'required' => 'The :fieldname: field is required',
        'min' => 'The :fieldname: field must be a minimum :rulevalue: characters',
        'max' => 'The :fieldname: field must be a maximum :rulevalue: characters',
        'email' => 'The :fieldname: field must be email, example: example@example.example',
    ];

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
        //        dump($this->attributes);
        //        dump($this->rules);
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
                //                            var_dump($field['fieldname'],$ruleValidator,$ruleValidator_value);
                //будет вызываться метод под именем ['required', 'min', 'max', 'email'];
                if (!call_user_func_array([$this, $ruleValidator], [$field['value'], $ruleValidator_value])) {
                    //                    var_dump("Error: {$field['fieldname']} - {$ruleValidator} ");
                    $this->addError(
                        $field['fieldname'],
                        str_replace(
                            [':fieldname:', ':rulevalue:'],
                            [$field['fieldname'], $ruleValidator_value],
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
        dump($this->errors);
        return $this->errors;
    }

    protected function hasErrors()
    {
        //        если есть ошибки, вернут тру
        return !empty($this->errors);
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