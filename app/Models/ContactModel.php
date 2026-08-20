<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ContactModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'contacts';

    protected $fillable = [
        'phone_number',
        'whatsapp_number',
        'email',
        'address',
        'business_hours',
        'facebook_url',
        'instagram_url',
        'website_content',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_slider')
            ->useDisk('public');

        $this->addMediaCollection('website_content')
            ->useDisk('public');
    }
}
