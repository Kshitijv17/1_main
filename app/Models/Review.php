<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'title',
        'comment',
        'is_verified',
        'is_approved'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_approved' => 'boolean',
        'helpful_votes' => 'array',
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who wrote the review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product being reviewed
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope for approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for verified reviews
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Get helpful votes count
     */
    public function getHelpfulVotesCountAttribute()
    {
        return is_array($this->helpful_votes) ? count($this->helpful_votes) : 0;
    }

    /**
     * Check if user found this review helpful
     */
    public function isHelpfulForUser($userId)
    {
        return is_array($this->helpful_votes) && in_array($userId, $this->helpful_votes);
    }

    /**
     * Toggle helpful vote for user
     */
    public function toggleHelpfulVote($userId)
    {
        $votes = $this->helpful_votes ?? [];
        
        if (in_array($userId, $votes)) {
            $votes = array_diff($votes, [$userId]);
        } else {
            $votes[] = $userId;
        }
        
        $this->helpful_votes = array_values($votes);
        $this->save();
        
        return !in_array($userId, $this->helpful_votes ?? []);
    }
}
