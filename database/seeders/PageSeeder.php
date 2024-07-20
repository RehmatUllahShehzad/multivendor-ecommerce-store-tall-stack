<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'id' => 1,
                'title' => 'Contact Us',
                'template' => 'contact-us',
            ],
            [
                'id' => 2,
                'title' => 'Disclaimer',
                'template' => 'disclaimer',
            ],
            [
                'id' => 3,
                'title' => 'Faqs',
                'template' => 'faqs',
            ],
            [
                'id' => 4,
                'title' => 'Our story',
                'template' => 'our-story',
            ],
            [
                'id' => 5,
                'title' => 'Sell now',
                'template' => 'sell-now',
            ],
            [
                'id' => 6,
                'title' => 'Terms & condition',
                'template' => 'terms-condition',
            ],
            [
                'id' => 7,
                'title' => 'Whats new',
                'template' => 'whats-new',
            ],
            [
                'id' => 8,
                'title' => 'Privacy Policy',
                'template' => 'privacy-policy',
            ],

        ];
        foreach ($pages as $page) {
            $content = view("frontend/theme/templates.{$page['template']}")->render();

            Page::firstOrCreate(
                [
                    'id' => $page['id'],
                ],
                [
                    'id' => $page['id'],
                    'title' => $page['title'],
                    'short_description' => $page['title'],
                    'gjs_data' => [
                        'html' => $content,
                        'page' => [
                            'component' => $content,
                        ],
                        'styles' => [],
                        'css' => '',
                    ],
                ]
            );
        }
    }
}
