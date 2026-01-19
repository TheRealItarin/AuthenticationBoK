<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextContent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'text',
        'updated_by'
    ];

    /**
     * Get the user who last updated this content.
     */
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
