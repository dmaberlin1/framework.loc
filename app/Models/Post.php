<?php

namespace App\Models;

use PHPFramework\Model;

class Post extends Model
{

    public array $fillable = ['title',  'content','slug'];

    public array $rules = [
        'name' => ['required' => true, 'min' => 2, 'max' => 50],
        'content' => ['required' => true, 'min' => 5, 'max' => 200],
        'slug'=>['required'=>true,'unique'=>'posts:slug']
    ];
    public array $labels=[
        'title' => 'Post title',
        'content'=>'Content',
        'slug'=>'Slug',
    ];


    protected static function tableName(): string
    {
        return 'posts';
    }
}