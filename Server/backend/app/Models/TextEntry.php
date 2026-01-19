<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextEntry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'text',
        'user_id'
    ];

    /**
     * Get the user who created this entry.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
