<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CmsContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'excerpt',
        'content',
        'meta_data',
        'featured_image',
        'gallery',
        'status',
        'sort_order',
        'is_featured',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'created_by',
        'updated_by',
        'published_at'
    ];

    protected $casts = [
        'meta_data' => 'array',
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime'
    ];

    protected $dates = [
        'published_at',
        'deleted_at'
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')
                    ->orderBy('created_at', 'desc');
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    // Accessors
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        if ($this->content) {
            return Str::limit(strip_tags($this->content), 150);
        }
        
        return null;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => '<span class="badge bg-secondary">Draft</span>',
            'published' => '<span class="badge bg-success">Published</span>',
            'archived' => '<span class="badge bg-warning">Archived</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-light">Unknown</span>';
    }

    public function getTypeBadgeAttribute()
    {
        $badges = [
            'page' => '<span class="badge bg-primary">Page</span>',
            'post' => '<span class="badge bg-info">Post</span>',
            'banner' => '<span class="badge bg-warning">Banner</span>',
            'section' => '<span class="badge bg-secondary">Section</span>'
        ];

        return $badges[$this->type] ?? '<span class="badge bg-light">Unknown</span>';
    }

    // Helper methods
    public function isPublished()
    {
        return $this->status === 'published' && 
               ($this->published_at === null || $this->published_at <= now());
    }

    public function getUrl()
    {
        return route('cms.show', $this->slug);
    }

    public function getFeaturedImageUrl()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        
        return asset('images/default-placeholder.jpg');
    }

    public function getGalleryUrls()
    {
        if (!$this->gallery || !is_array($this->gallery)) {
            return [];
        }

        return array_map(function($image) {
            return asset('storage/' . $image);
        }, $this->gallery);
    }
}
