<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Body extends Model
{
    use HasFactory;

    protected $fillable = [
        'idSite',
        'indexPage',
        'type',
        'idtype',
        'type2',
        'idtype2',
    ];

    protected $table = 'bodies';

    public function site()
    {
        return $this->belongsTo(Site::class, 'idSite');
    }

    public function texts()
    {
        return $this->hasMany(Text::class, 'idCol');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'idCol');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'idCol');
    }
}
