<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'latitude',
        'longitude',
        'address',
        'description',
        'rating',
        'status',
        'has_toilet',
        'has_musholla',
        'has_wifi',
        'has_camping',
    ];

    protected $casts = [
        'has_toilet'   => 'boolean',
        'has_musholla' => 'boolean',
        'has_wifi'     => 'boolean',
        'has_camping'  => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
?>
