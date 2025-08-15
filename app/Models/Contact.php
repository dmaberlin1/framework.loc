<?php

namespace App\Models;

use PHPFramework\Model;

class Contact extends Model
{
    public array $fillable = ['name', 'nickname', 'email', 'content',];
    public array $attributes = ['role' => 'user'];
    public array $rules = [
        'name' => ['required' => true, 'min' => 2, 'max' => 50],
        'nickname' => ['required' => false, 'min' => 2, 'max' => 50],
        'email' => ['email' => true, 'min' => 5, 'max' => 50],
        'content' => ['required' => true, 'min' => 5, 'max' => 1000],
        'thumbnails' => ['ext' => 'jpg|jpeg|png', 'size' => 1_048_576],

    ];
    public array $labels=[
        'name' => 'Name',
        'email' => 'E-mail',
        'content'=>'Content',
    ];


    protected static function tableName(): string
    {
        return 'contacts';
    }
}