<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Destination;
use App\Models\Culinary;
use App\Models\Stay;

class TravelPackage extends Model
{
    use HasFactory;

    protected $table = 'travel_packages';

    protected $fillable = [
        'name',
        'total_price',
        'description',
    ];

    // Relasi many-to-many dengan destinations
    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'destination_travel_package', 'travel_package_id', 'id_destinations');
    }

    // Relasi many-to-many dengan culinaries
    public function culinaries()
    {
        return $this->belongsToMany(Culinary::class, 'culinary_travel_package', 'travel_package_id', 'id_culinaries');
    }

    // Relasi many-to-many dengan stays
    public function stays()
    {
        return $this->belongsToMany(Stay::class, 'stay_travel_package', 'travel_package_id', 'id_stays');
    }
}
