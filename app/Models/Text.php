<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use HasFactory;

    protected $fillable = [
        'idCol',
        'titleText',
        'positionTitle',
        'text',
        'positionText',
    ];

    protected $table = 'texts';

    public function body()
    {
        return $this->belongsTo(Body::class, 'idCol');
    }
}
