<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GalleryModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'galleries';

    protected $fillable = [
        'id',
        'gallery_category_id',
        'title',
        'slug',
        'location',
        'event_date',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover_image')
            ->singleFile();

        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400);

        $this->addMediaConversion('medium')
            ->width(1200);
    }

    public function category()
    {
        return $this->belongsTo(GalleryCategoryModel::class, 'gallery_category_id');
    }

    public function coverImage()
    {
        return $this->hasOne(Media::class, 'model_id', 'id')
            ->where('model_type', self::class)
            ->where('collection_name', 'cover_image');
    }
}
