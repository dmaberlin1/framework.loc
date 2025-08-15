<?php

namespace PHPFramework;

abstract class Model
{

    protected readonly string $table;
    //    разрешенные для записи поля
    protected array $fillable = [];
    //    public array $fillable = ['email', 'content'];

    //    поля
    public array $attributes = [];
    protected array $rules = [];
    protected array $labels = [];
    protected array $data_items=[];

    protected array $errors = [];
    protected array $rules_list = ['required', 'min', 'max', 'email', 'unique', 'file', 'ext', 'size','match'];
    protected array $messages = [
        'required' => ':fieldname: field is required',
        'min' => ':fieldname: field must be a minimum :rulevalue: characters',
        'max' => ':fieldname: field must be a maximum :rulevalue: characters',
        'email' => ':fieldname: field must be email, example: example@example.example',
        'unique' => ':fieldname: is already taken',
        'file' => ':fieldname: field is required',
        'ext' => 'File :fieldname: extension does not match. Allowed :rulevalue:',
        'size' => 'File :fieldname: is too large. Allowed :rulevalue: bytes',
        'match' => ':fieldname: field must match with :rulevalue: field',
    ];

    public function __construct()
    {
        $this->table = static::tableName();
    }

    abstract protected static function tableName(): string;

    public function save(): false|string
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

    public function update()
    {
        // update table set `title`=:title,`content`=:content where `id`=:id
        if (!isset($this->attributes['id'])) {
            return false;
        }
        $fields = '';
        foreach ($this->attributes as $k => $v) {
            if ($k == 'id') {
                continue;
            }
            $fields .= "`{$k}`=:{$k},";
        }
        $fields = rtrim($fields, ',');
        $query = "UPDATE {$this->table} SET {$fields} WHERE `id`=:id";
        db()->query($query, $this->attributes);
//        dump($query);
        return db()->rowCount();

    }

    public function delete(int $id): int
    {
        db()->query("DELETE FROM {$this->table} WHERE id= ?", [$id]);
        return db()->rowCount();
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

    public function validate($data=[],$rules=[]): bool
    {
             if(!$data){
                      $data=$this->attributes;
             }
             if(!$rules){
                 $rules=$this->rules;
             }

             $this->data_items=$data;
        foreach ($data as $fieldName => $fieldValue) {
            if (isset($rules[$fieldName])) {
                $this->check([
                    'fieldname' => $fieldName,
                    'value' => $fieldValue,
                    'rules' => $rules[$fieldName]
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

    public function listErrors(): string
    {
        $output = '<ul class="list-unstyled">';
        foreach ($this->errors as $field_errors) {
            foreach ($field_errors as $error) {
                $output .= "<li>{$error}</li>";
            }
        }
        $output .= '</ul>';
        return $output;
    }

    protected function required($value, $rule_value): bool
    {
        return !empty(trim($value));
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
    protected function match($value,$rule_value):bool
    {
//        dump($value);
//        dump($rule_value);
//        dump($this->data_items);

        return $value===$this->data_items[$rule_value];

    }

    protected function unique($value, $rule_value): bool
    {
        $data = explode(':', $rule_value);
        $table = $data[0];
        $field = $data[1];
        if(str_contains($data[1],',')){
            $data_fields=explode(',',$field);
            $currentId = $this->data_items[$data_fields[1]];
            $result = db()->findUniqueWithExclude($table, $data_fields, $value, $currentId);
            $boolResult = is_array($result);
            //        dd(!$boolResult);
            return !$boolResult;
        }

        $result = db()->findUnique($table, $field, $value);
        $boolResult = is_array($result);
        //        dd(!$boolResult);
        return !$boolResult;
    }

    protected function file($value, $rule_value)
    {
        $value_error = $value['error'];

        if (isset($value_error) && is_array($value_error)) {
            foreach ($value_error as $file_error) {
                if ($file_error !== 0) {
                    return false;
                }
            }
        } elseif (isset($value_error) && $value_error !== 0) {
            return false;
        }
        return true;
    }

    protected function ext($value, $rule_value): bool
    {
        //        array files
        if (is_array($value['name'])) {
            if (empty($value['name'][0])) {
                return true;
            }
            for ($i = 0, $iMax = count($value['name']); $i < $iMax; $i++) {
                $file_ext = get_file_ext($value['name'][$i]);
                $allowed_exts = explode('|', $rule_value);
                if (!in_array($file_ext, $allowed_exts)) {
                    return false;
                }
            }
            return true;
        }

        //        one file
        if (empty($value['name'])) {
            return true;
        }
        $file_ext = get_file_ext($value['name']);
        $allowed_exts = explode('|', $rule_value);
        return in_array($file_ext, $allowed_exts);
    }

    protected function size($value, $rule_value): bool
    {
        $value_size = $value['size'];
        if (is_array($value_size)) {
            if (empty($value_size[0])) {
                return true;
            }
            for ($i = 0, $iMax = count($value_size); $i < $iMax; $i++) {
                if ($value_size[$i] > $rule_value) {
                    return false;
                }
            }
            return true;
        }
        if (empty($value_size)) {
            return true;
        }
        return $value_size <= $rule_value;
    }
}