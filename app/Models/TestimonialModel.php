<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TestimonialModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'testimonial';

    protected $fillable = [
        'name',
        'description',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('testimonial_photo')->singleFile();
    }
}
