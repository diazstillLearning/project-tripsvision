<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stay extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai konvensi Laravel)
    protected $table = 'stays';

    // Primary key kustom
    protected $primaryKey = 'id_stays';

    // Auto-increment
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    // Kolom-kolom yang bisa diisi massal
    protected $fillable = [
        'name',
        'location',
        'price_range',
        'rating',
        'amenities',
        'description',
        'image_url',
        'id_destinations',
    ];

    protected $casts = [
        'amenities' => 'array', // Jika amenities disimpan sebagai JSON
    ];

    // Relasi: Stay milik satu Destination
    public function destinations()
{
    return $this->belongsToMany(Destination::class, 'destination_stay', 'stay_id', 'destination_id');
}


}
