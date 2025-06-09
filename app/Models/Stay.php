<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Destination;

class Stay extends Model
{
    use HasFactory;

    protected $table = 'stays';
    protected $primaryKey = 'id_stays';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'location',
        'price',
        'rating',
        'amenities',
        'description',
        'image_url',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'amenities' => 'array', // Jika disimpan sebagai JSON
    ];

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'destination_stay', 'stay_id', 'destination_id');
    }
}
