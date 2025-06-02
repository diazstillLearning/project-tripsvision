<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Culinary extends Model
{
    use HasFactory;

    // Nama tabel (opsional, Laravel otomatis membaca dari nama model jamak)
    protected $table = 'culinaries';

    // Primary key custom
    protected $primaryKey = 'id_culinaries';

    // Auto-increment
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    // Kolom-kolom yang boleh diisi massal
    protected $fillable = [
        'id_destinations',
        'name',
        'location',
        'price_range',
        'rating',
        'cuisine_type',
        'description',
        'image_url',
    ];

    // Relasi: Culinary milik satu Destination
    public function destinations()
{
    return $this->belongsToMany(Destination::class, 'culinary_destination', 'culinary_id', 'destination_id');
}

}
