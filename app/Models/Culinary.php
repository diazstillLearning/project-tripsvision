<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Destination;

class Culinary extends Model
{
    use HasFactory;

    protected $table = 'culinaries';
    protected $primaryKey = 'id_culinaries';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'location',
        'price_range',
        'rating',
        'cuisine_type',
        'description',
        'image_url',
        'latitude',
        'longitude',
    ];

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'culinary_destination', 'culinary_id', 'destination_id');
    }
}
