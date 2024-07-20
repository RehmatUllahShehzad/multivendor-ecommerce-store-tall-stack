<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = collect([
            'header', 'footer-shop', 'footer-learn',
        ])
            ->map(
                fn ($name) => Menu::query()
                    ->firstOrCreate(compact('name'))
            )
            ->pluck('id', 'name');

        collect([
            1 => [
                'menu' => 'header',
                'title' => 'Aisles',
                'link' => '/product-listing',
            ],
            2 => [
                'menu' => 'header',
                'title' => 'WHAT\'S NEW?',
                'link' => '/whats-new',
            ],
            3 => [
                'menu' => 'header',
                'title' => 'FAQS',
                'link' => '/faqs',
            ],
            4 => [
                'menu' => 'header',
                'title' => 'ABOUT US',
                'link' => '/our-story',
            ],
            5 => [
                'menu' => 'footer-shop',
                'title' => 'All Products',
                'link' => '/product-listing',
            ],
            6 => [
                'menu' => 'footer-shop',
                'title' => 'What’s New',
                'link' => '/whats-new',
            ],
            7 => [
                'menu' => 'footer-shop',
                'title' => 'Sell Now',
                'link' => '/sell-now',
            ],
            8 => [
                'menu' => 'footer-shop',
                'title' => 'Contact Us',
                'link' => '/contact-us',
            ],
            9 => [
                'menu' => 'footer-learn',
                'title' => 'Our Story',
                'link' => '/our-story',
            ],
            10 => [
                'menu' => 'footer-learn',
                'title' => 'FAQs',
                'link' => '/faqs',
            ],
            11 => [
                'menu' => 'footer-learn',
                'title' => 'Disclaimer',
                'link' => '/disclaimer',
            ],
            12 => [
                'menu' => 'footer-learn',
                'title' => 'Privacy Policy',
                'link' => '/privacy-policy',
            ],
            13 => [
                'menu' => 'footer-learn',
                'title' => 'Terms & Conditions',
                'link' => '/terms-condition',
            ],
        ])
        ->map(fn ($item, $key) => MenuItem::firstOrCreate(['id' => $key], [
            'menu_id' => $menus[$item['menu']],
            'title' => $item['title'],
            'link' => $item['link'],
        ]));
    }
}
