<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Culinary;
use App\Models\Stay;

class Destination extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai konvensi Laravel)
    protected $table = 'destinations';

    // Primary key custom (karena kamu pakai 'id_destinations')
    protected $primaryKey = 'id_destinations';

    // Auto-incrementing key default true (ubah ke false jika tidak pakai auto increment)
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'name',
        'location',
        'price_range',
        'rating',
        'description',
        'category',
        'image_url',
    ];

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
