<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Culinary;
use App\Models\Stay;

class Destination extends Model
{
    use HasFactory;

    protected $table = 'destinations';
    protected $primaryKey = 'id_destinations';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'location',
        'price',
        'price_range',
        'rating',
        'description',
        'category',
        'image_url1',
        'image_url2',
        'image_url3',
        'latitude',
        'longitude',
    ];

    // Jika ingin pakai 'id' secara default
    public function getIdAttribute()
    {
        return $this->attributes['id_destinations'];
    }

    public function culinaries()
    {
        return $this->belongsToMany(Culinary::class, 'culinary_destination', 'destination_id', 'culinary_id');
    }

    public function stays()
    {
        return $this->belongsToMany(Stay::class, 'destination_stay', 'destination_id', 'stay_id');
    }
}
