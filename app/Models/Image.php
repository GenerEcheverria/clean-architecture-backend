<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'idCol',
        'url',
        'size',
        'text',
    ];

    protected $table = 'images';

    public function body()
    {
        return $this->belongsTo(Body::class, 'idCol');
    }
}
