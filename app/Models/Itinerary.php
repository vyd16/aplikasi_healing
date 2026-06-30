<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'start_date',
        'end_date',
        'share_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ItineraryItem::class)->orderBy('day_number')->orderBy('order');
    }

    /**
     * Generate a unique share token for this itinerary.
     */
    public function generateShareToken(): string
    {
        $token = Str::random(32);
        $this->share_token = $token;
        $this->save();
        return $token;
    }
}
