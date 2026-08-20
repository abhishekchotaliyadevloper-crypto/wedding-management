<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryModel extends Model
{
    protected $table = 'inquiries';

    protected $fillable = [
        'name',
        'contact_number',
        'subject',
        'email',
        'message',
    ];
}
