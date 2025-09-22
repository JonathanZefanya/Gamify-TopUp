<?php

namespace Database\Seeders;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
//            ['name' => 'Card','slug' => 'cards', 'template_name' => 'dark', 'type' => 1],
//            ['name' => 'Top Up','slug' => 'top-ups', 'template_name' => 'dark', 'type' => 1],
//            ['name' => 'Blog','slug' => 'blogs', 'template_name' => 'dark', 'type' => 1],
//            ['name' => 'Buy','slug' => 'buy', 'template_name' => 'dark', 'type' => 1],

//            ['name' => 'Card','slug' => 'cards', 'template_name' => 'light', 'type' => 1],
//            ['name' => 'Top Up','slug' => 'top-ups', 'template_name' => 'light', 'type' => 1],
//            ['name' => 'Blog','slug' => 'blogs', 'template_name' => 'light', 'type' => 1],
//            ['name' => 'Buy','slug' => 'buy', 'template_name' => 'light', 'type' => 1],
        ];
        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                array_merge($page, [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ])
            );
        }

    }
}
