<?php

use App\Models\Menu;
use App\Models\State;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;

function getStates($columns = ['id', 'code'], $country_id = null)
{
    return State::select($columns)->where('country_id', $country_id)->orderBy('name')->get();
}

if (!function_exists('get_max_fileupload_size')) {

    function get_max_fileupload_size($maxUploadSize = null)
    {
        $maxAllowedServerSize = (int) ini_get('upload_max_filesize') * 1024;

        $mediaLibraryAllowedSize = config('media-library.max_file_size', 10000000000000) / 1024;

        $appConfiguredMaxSize = ($mediaLibraryAllowedSize < $maxAllowedServerSize) ? $mediaLibraryAllowedSize : $maxAllowedServerSize;

        if (!$maxUploadSize) {
            return $appConfiguredMaxSize;
        }

        if ($maxUploadSize < $appConfiguredMaxSize) {
            return $maxUploadSize;
        }

        return $appConfiguredMaxSize;
    }
}

/**
 * Get 12 months list
 *
 * @return array|\Illuminate\Support\Collection
 */
function get_12_months()
{
    return collect(range(1, 12))->mapWithKeys(function ($month) {
        return [$month => \Carbon\Carbon::now()->startOfYear()->addMonths($month - 1)->monthName];
    })->toArray();
}

/**
 * Get next n years list
 *
 * @param  int  $how_many
 * @param  bool  $as_options
 * @return array|\Illuminate\Support\Collection
 */
function get_next_years($how_many = 10, $as_options = false)
{
    $current_year = date('Y');
    $years = collect(range($current_year, $current_year + $how_many));

    if ($as_options) {
        return $years
            ->mapWithKeys(fn ($year) => [$year => $year])
            ->toArray();
    }

    return $years;
}

function getFormattedCardNumber($number)
{
    return str_pad($number, 16, '*', STR_PAD_LEFT);
}

/**
 * Cast and get the meta as object for the given model
 *
 * @param  \Illuminate\Database\Eloquent\Model  $model
 * @param  null|string  $key
 * @param  mixed  $default
 * @return mixed
 */
function cast_meta_object(Model $model, $key = null, $default = null)
{
    $meta = $model->meta;

    if (is_string($meta)) {
        $meta = json_decode($meta);
    }

    if (!is_object($meta)) {
        $meta = (object) $meta;
    }

    if (is_null($meta)) {
        $meta = new stdClass();
    }

    if (!is_null($key)) {
        return $meta->{$key} ?? $default;
    }

    return $meta;
}

if (!function_exists('vite')) {
    function vite($resource, $buildDirectory = 'tallAdmin')
    {
        return app(Vite::class)($resource, $buildDirectory);
    }
}

if (!function_exists('viteCssPath')) {
    function viteCssPath(string $resource, $buildDirectory = 'tallAdmin')
    {
        return Str::of(vite($resource, $buildDirectory))->after('href="')->before('" />')->toString();
    }
}

if (!function_exists('viteJsPath')) {
    function viteJsPath(string $resource, $buildDirectory = 'tallAdmin')
    {
        return Str::of(vite($resource, $buildDirectory))->after('src="')->before('">')->toString();
    }
}

if (!function_exists('db_date')) {
    function db_date($column, $format, $alias = null)
    {
        $connection = config('database.default');

        $driver = config("database.connections.{$connection}.driver");

        $select = "DATE_FORMAT({$column}, '{$format}')";

        if ($driver == 'pgsql') {
            $format = str_replace('%', '', $format);
            $select = "TO_CHAR({$column} :: DATE, '{$format}')";
        }

        if ($driver == 'sqlite') {
            $select = "strftime('{$format}', {$column})";
        }

        if ($alias) {
            $select .= " as {$alias}";
        }

        return DB::RAW($select);
    }

    if (!function_exists('array_keys_exists')) {
        /**
         * Easily check if multiple array keys exist.
         *
         * @param  array  $keys
         * @param  array  $arr
         * @return bool
         */
        function array_keys_exists(array $keys, array $arr)
        {
            return !array_diff_key(array_flip($keys), $arr);
        }
    }

    if (!function_exists('setting')) {
        /**
         * Get / set the specified setting value.
         *
         * If an array is passed as the key, we will assume you want to set an array of values.
         *
         * @param  array|string  $key
         * @param  mixed  $default
         * @return mixed
         */
        function setting($key = null, $default = null)
        {
            $setting = app('setting');

            if (is_null($key)) {
                return $setting;
            }

            if (is_array($key)) {
                $setting->set($key);

                return $setting;
            }

            return $setting->get($key, $default);
        }
    }
}

function getBestProducts(int $limit = 8)
{
    return Product::with([
        'thumbnail',
        'user.vendor',
    ])->withAvgRating()->featured()->published()->latest()->limit($limit)->get();
}

function getProducts(int $limit = 8)
{
    return Product::query()
        ->with([
            'thumbnail',
            'user.vendor',
        ])
        ->withAvgRating()
        ->published()
        ->limit($limit)
        ->get();
}

function html($html): HtmlString
{
    return new HtmlString($html);
}

function getSavedLocation()
{
    if(request('location') === 'false'){
        return [];
    }

    return [
        'lat' => request('location.lat', Cookie::get('saved_location_lat')),
        'lng' => request('location.lng', Cookie::get('saved_location_lng')),
    ];
}

function getMenu($name)
{
    return Menu::getMenuByName($name);
}

function getDummyImage()
{
    return asset('/frontend/images/sample.jpg');
}
