<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoModel extends Model
{
    protected $table = 'videos';

    protected $fillable = [
        'id',
        'gallery_id',
        'title',
        'url',
        'description',
    ];

    public function gallery()
    {
        return $this->belongsTo(GalleryModel::class, 'gallery_id');
    }
}
