<?php

namespace App\Models;

use PHPFramework\Model;

class Post extends Model
{

    public array $fillable = ['title',  'content'];

    public array $rules = [
        'name' => ['required' => true, 'min' => 2, 'max' => 50],
        'content' => ['required' => true, 'min' => 5, 'max' => 200],
    ];
    public array $labels=[
        'title' => 'Post title',
        'content'=>'Content',
    ];


    protected static function tableName(): string
    {
        return 'posts';
    }
}