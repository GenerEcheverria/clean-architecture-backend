<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'idSite',
        'backgroundColor',
        'textColor',
        'setSocialMedia',
        'facebook',
        'twitter',
        'instagram',
        'tiktok',
        'linkedin',
        'otro',
        'setContact',
        'address',
        'phone',
        'setExtra',
        'text',
        'image',
    ];

    protected $table = 'footers';

    public function site()
    {
        return $this->belongsTo(Site::class, 'idSite');
    }
}
