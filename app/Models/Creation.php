<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Creation extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = ['title', 'slug', 'category', 'description'];

    protected $with = ['author', 'media'];

    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this->addMediaConversion('thumb')
    //         ->width(300)
    //         ->height(200)
    //         ->performOnCollections('creation');
    // }

    // queries
    public static function categoryList($user)
    {
        return static::query()
            ->select('category', DB::raw('count(*) as total'))
            ->where('user_id', $user->id)
            ->groupBy('category')
            ->get();
    }

    public static function globalCategory()
    {
        return static::query()
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();
    }

    public static function globalCreations()
    {
        return static::query()
            ->get();
    }
    public static function allCreations($user)
    {
        return static::query()
            ->where('user_id', $user->id)
            ->get();
    }
    public static function categoryCreations($categories)
    {
        return static::query()
            ->whereIn('category', $categories)
            ->get();
    }
    public static function creations($categories, $user)
    {
        return static::query()
            ->where('user_id', $user->id)
            ->whereIn('category', $categories)
            ->get();
    }



    // relations
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
