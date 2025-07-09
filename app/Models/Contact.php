<?php

namespace App\Models;

use PHPFramework\Model;

class Contact extends Model
{
    public array $fillable = ['name', 'nickname', 'email', 'content', 'field_without_data'];
    public array $attributes = ['role' => 'user'];
    public array $rules = [
        'name' => ['required' => true, 'min' => 2, 'max' => 50],
        'nickname' => ['required' => false, 'min' => 2, 'max' => 50],
        'email' => ['email' => true, 'min' => 5, 'max' => 50],
        'content' => ['required' => true, 'min' => 5, 'max' => 200],
    ];

}