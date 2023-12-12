<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'backgroundColor', 'views', 'idUser', 'url', 'state',
    ];

    protected $table = 'sites';

    public function bodies()
    {
        return $this->hasMany(Body::class, 'idSite');
    }

    public function headers()
    {
        return $this->hasMany(Header::class, 'idSite');
    }

    public function footers()
    {
        return $this->hasMany(Footer::class, 'idSite');
    }
}
