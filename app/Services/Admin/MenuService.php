<?php

namespace App\Services\Admin;

use App\Menu\Menu;
use App\Menu\MenuItem;
use Exception;
use Illuminate\Support\Collection;

class MenuService
{
    public static function menu(string $name): Menu
    {
        return (new self())->get($name);
    }

    /**
     * @throws Exception
     */
    public function get(string $name): Menu
    {
        /** @var \App\Menu\Menu | null */
        $menu = $this->getMenuList()->where('name', $name)->first();

        if (! $menu) {
            throw new Exception("Menu Not found with name \"{$name}\"");
        }

        return $menu;
    }

    private function getMenuList(): Collection
    {
        return collect([
            /**
             * Main Sidebar Menu
             */
            Menu::make('main')
                ->addItem(function (MenuItem $item) {
                    $item->name('Dashboard')
                        ->handle('admin.dashboard')
                        // ->permission('admin:dashboard')
                        ->icon('chart-square-bar')
                        ->route('admin.dashboard');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Catalog')
                        ->handle('admin.catalog')
                        ->permission('catalog')
                        ->icon('collection')
                        ->route('admin.catalog.product.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('CMS')
                        ->handle('admin.cms')
                        ->permission('cms')
                        ->icon('cube')
                        ->route('admin.cms.menu.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Customer')
                        ->handle('admin.customer')
                        ->permission('manage-customers')
                        ->icon('user')
                        ->route('admin.customer.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Order')
                        ->handle('admin.order')
                        ->permission('manage-orders')
                        ->icon('shopping-cart')
                        ->route('admin.order.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Forms')
                        ->handle('admin.forms')
                        ->permission('forms')
                        ->icon('document-duplicate')
                        ->route('admin.forms.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Reports')
                        ->handle('admin.reports')
                        ->permission('reports')
                        ->icon('search')
                        ->route('admin.reports.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('System')
                        ->handle('admin.system')
                        ->permission('system')
                        ->icon('cog')
                        ->route('admin.system.staff.index');
                }),

            /**
             * CMS Menu
             */
            Menu::make('cms')
                ->addItem(function (MenuItem $item) {
                    $item->name('Menu')
                        ->handle('admin.cms.menu')
                        ->permission('cms:manage-menu')
                        ->icon('menu')
                        ->route('admin.cms.menu.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Pages')
                        ->handle('admin.pages')
                        ->permission('pages')
                        ->icon('template')
                        ->route('admin.pages.index');
                }),

            /**
             * System Menu
             */
            Menu::make('system')
                ->addItem(function (MenuItem $item) {
                    $item->name('Staff')
                        ->handle('admin.system.staff')
                        ->route('admin.system.staff.index')
                        ->permission('system:manage-staff')
                        ->icon('identification');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Unit')
                        ->handle('admin.system.unit')
                        ->route('admin.system.unit.index')
                        ->permission('system:manage-unit')
                        ->icon('collection');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Settings')
                        ->handle('admin.system.setting')
                        ->route('admin.system.setting.index')
                        ->permission('system:settings')
                        ->icon('cog');
                }),

            /**
             * Catalog Menu
             */
            Menu::make('catalog')
                ->addItem(function (MenuItem $item) {
                    $item->name('Product')
                        ->handle('admin.catalog.product')
                        ->route('admin.catalog.product.index')
                        ->permission('catalog:manage-product')
                        ->icon('cube');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Categories')
                        ->handle('admin.catalog.category')
                        ->route('admin.catalog.category.index')
                        ->permission('catalog:manage-category')
                        ->icon('collection');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Nutrition')
                        ->handle('admin.catalog.nutrition')
                        ->route('admin.catalog.nutrition.index')
                        ->permission('catalog:manage-nutrition')
                        ->icon('chart-pie');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Dietary Restricitons')
                        ->handle('admin.catalog.dietary')
                        ->route('admin.catalog.dietary.index')
                        ->permission('catalog:manage-dietary-restrictions')
                        ->icon('ban');
                }),

            /**
             * Customer Menu
             */
            Menu::make('customer')
                ->addItem(function (MenuItem $item) {
                    $item->name('Profile')
                        ->handle('customer.profile')
                        ->icon('profile-icon')
                        ->route('customer.profile');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Addresses')
                        ->handle('customer.addresses')
                        ->icon('c-ad')
                        ->route('customer.addresses.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Payments')
                        ->handle('customer.payment')
                        ->icon('payment-history-icon')
                        ->route('customer.payment.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('My Orders')
                        ->handle('customer.orders.index')
                        ->icon('your-order-icon')
                        ->route('customer.orders.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Your Messages')
                        ->handle('customer.messages')
                        ->icon('your-message-icon')
                        ->route('customer.messages');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Login Security ')
                        ->handle('customer.login.security')
                        ->icon('log')
                        ->route('customer.login.security');
                }),

            /**
             * Vendor Menu
             */
            Menu::make('vendor')
                ->addItem(function (MenuItem $item) {
                    $item->name('My Profile')
                        ->handle('vendor.profile')
                        ->icon('profile-icon')
                        ->route('vendor.profile');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Product Management')
                        ->handle('vendor.product')
                        ->icon('product-management-icon')
                        ->route('vendor.product.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Product Reviews')
                        ->handle('vendor.reviews')
                        ->icon('product-review-icon')
                        ->route('vendor.reviews');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Your Orders')
                        ->handle('vendor.orders')
                        ->icon('your-order-icon')
                        ->route('vendor.orders');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Your Messages')
                        ->handle('vendor.messages')
                        ->icon('your-message-icon')
                        ->route('vendor.messages');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Payment History')
                        ->handle('vendor.payment.history')
                        ->icon('payment-history-icon')
                        ->route('vendor.payment.history.index');
                }),
        ]);
    }
}
