<?php

namespace App\Models;

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
     * Display only published articles
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', '!=', 'null');
    }

    /**
     * Display filtered articles by filter on index page
     * @param $query
     * @param Request $request
     */
    public function scopeFiltered($query, Request $request)
    {
        if ($request->filled('title')) {
            $query->where('title', 'LIKE', '%' . $request->input('title') . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', '=', $request->input('category'));
        }
        if ($request->filled('author')) {
            $query->where('user_id', '=', $request->input('author'));
        }
        if ($request->filled('published')) {
            $query->where('is_published', '=', $request->input('published'));
        }
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
