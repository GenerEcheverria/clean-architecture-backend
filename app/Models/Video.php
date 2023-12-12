<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'idCol',
        'url',
        'size',
    ];

    protected $table = 'videos';

    public function body()
    {
        return $this->belongsTo(Body::class, 'idCol');
    }
}
