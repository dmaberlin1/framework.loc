<?php

namespace App\Models;

use PHPFramework\Model;

class Post extends Model
{

    public array $fillable = ['title', 'content', 'slug'];

    public array $rules = [
        'name' => ['required' => true, 'min' => 2, 'max' => 50],
        'content' => ['required' => true, 'min' => 5, 'max' => 200],
        'slug' => ['required' => true, 'unique' => 'posts:slug'],
        'thumbnail' => ['ext' => 'jpg|jpeg|png', 'size' => 1_048_576],
        'thumbnails' => ['file' => true, 'ext' => 'jpg|jpeg|png', 'size' => 1_048_576]
    ];
    public array $labels = [
        'title' => 'Post title',
        'content' => 'Content',
        'slug' => 'Slug',
        'thumbnail' => 'Thumbnail',
    ];


    protected static function tableName(): string
    {
        return 'posts';
    }

    public function savePost(): false|string
    {
        $thumbnail = $this->attributes['thumbnail']['name'] ? $this->attributes['thumbnail'] : null;
        $thumbnails = $this->attributes['thumbnail']['name'][0] ? $this->attributes['thumbnail'] : null;
        unset($this->attributes['thumbnail'], $this->attributes['thumbnails']);
        dd($thumbnails);
        $id = $this->save();
        if ($thumbnail) {
            if ($file_url = upload_file($thumbnail)) {
                db()->query("UPDATE posts set `thumbnail`=? where id = ?", [$file_url, $id]);
            }
        }
        if ($thumbnails) {
            for ($i = 0, $iMax = count($thumbnails['name']); $i < $iMax; $i++) {
                if ($file_url = upload_file($thumbnails,$i)) {
                    db()->query("INSERT into gallery (post_id,image) values(?,?) ", [$id,$file_url]);
                }
            }

        }
        return $id;
    }
}