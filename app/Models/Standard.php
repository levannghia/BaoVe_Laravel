<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Standard extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    public $timestamps = false;
    public $translatedAttributes = ['title', 'description', 'standard_id','locale'];
}
