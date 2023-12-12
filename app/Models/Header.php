<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use HasFactory;

    protected $fillable = [
        'idSite', 'title', 'size', 'position', 'color', 'hero', 'image',
    ];

    protected $table = 'headers';

    public function site()
    {
        return $this->belongsTo(Site::class, 'idSite');
    }
}
