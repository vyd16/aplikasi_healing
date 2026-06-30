<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'mediable_id',
        'mediable_type',
        'type', // photo or video
        'path',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }

    /**
     * Get the full URL for the media asset, supporting both local storage and external links.
     */
    public function getUrlAttribute(): string
    {
        if (filter_var($this->path, FILTER_VALIDATE_URL)) {
            return $this->path;
        }
        return asset('storage/' . $this->path);
    }
}
?>
