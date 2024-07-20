<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EditorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Page $page): View
    {
        config()->set('laraeditor.styles', [
            asset('frontend/css/bootstrap.min.css'),
            asset('frontend/css/font-awesome.css'),
            asset('frontend/css/style.css'),
            asset('frontend/css/cart.css'),
        ]);

        return $page->getEditor();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, Page $page): Response
    {
        return $page->saveEditorData($request);
    }

    public function templates(Page $page): array
    {
       return array_merge(
           $page->loadBlocks(resource_path('views/frontend/theme/blocks'), 'Blocks'),
           $page->loadBlocks(resource_path('views/frontend/theme/sections'), 'Sections'),
           $page->loadBlocks(resource_path('views/frontend/theme/templates'), 'Templates'),
        );
    }
}
