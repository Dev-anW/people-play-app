<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'requested_data',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    // Cast the requested_data attribute from JSON to an array automatically
    protected $casts = [
    'requested_data' => 'array',
    'reviewed_at' => 'datetime', // Add this line
];
    // A request belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A request was reviewed by an admin (another user)
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}