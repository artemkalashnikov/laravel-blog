<?php

namespace App\Models;

use App\Filters\QueryFiltersCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class BlogArticle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'fragment',
        'content',
        'is_published',
        'published_at',
    ];

    /**
     * Return only published articles
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', '!=', 'null');
    }

    /**
     * Filtering articles
     * @param $query
     * @param QueryFiltersCollection $filters
     */
    public function scopeFilter($query, QueryFiltersCollection $filters)
    {
        $filters->apply($query);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
