<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class News extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    protected $table = 'news';
    public $translatedAttributes = ['title', 'description', 'content', 'news_id','locale'];
}
