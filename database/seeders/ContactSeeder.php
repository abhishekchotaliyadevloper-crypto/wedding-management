<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactModel;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactModel::create([
            'phone_number' => '123-456-7890',
            'whatsapp_number' => '123-456-7890',
            'email' => 'contact@example.com',
            'address' => '123 Main St, City, State 12345',
            'business_hours' => 'Mon-Fri: 9AM-5PM, Sat: 10AM-2PM',
            'facebook_url' => 'https://www.facebook.com/example',
            'instagram_url' => 'https://www.instagram.com/example',
            'youtube_url' => 'https://www.youtube.com/example',
        ]);
    }
}
