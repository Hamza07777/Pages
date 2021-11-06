<?php

namespace Modules\Pages\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'show_on_main_menu',
        'show_on_footer_menu',
        'content',
        'status',

    ];

    protected static function newFactory()
    {
        return \Modules\Pages\Database\factories\PagesFactory::new();
    }
}
