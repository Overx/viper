<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customization extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customizations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'expanded_layout',
        'card_type',
        'header_type',
        'side_type',
        'footer_type',
        'primary_color',
        'primary_border_color',
        'primary_text',
        'secondary_color',
        'background_color',
        'footer_color',
    ];

}
