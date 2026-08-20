<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class GalleryCategoryModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'gallery_category';

    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('category_image')->singleFile();
        $this->addMediaCollection('category_video')->singleFile();
    }

    public function galleries()
    {
        return $this->hasMany(GalleryModel::class, 'gallery_category_id');
    }
}
