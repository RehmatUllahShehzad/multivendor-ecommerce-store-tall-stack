<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Page $page = null)
    {
        if (! $page) {
            $page = Page::whereSlug('/')->first();
        }

        if (! $page) {
            $featuredCategories = Category::featured()->latest()->limit(5)->get();

            return view('frontend.pages.home', compact('featuredCategories'));
        }

        abort_if(! $page->isActive(), 404);

        $this->setPlaceholders($page, $this->getPlaceholders($page->html));

        return view('frontend.pages.index', compact('page'));
    }

    public function setPlaceholders(Page $page, $placeholders = [])
    {
        foreach ($placeholders as $placeholder) {
            $viewPath = 'frontend.placeholders.'.strtolower($placeholder);
            if (! view()->exists($viewPath)) {
                continue;
            }

            $page->setPlaceholder("[[{$placeholder}-Placeholder]]", view($viewPath, compact('page'))->render());
        }
    }

    public function getPlaceholders($content)
    {
        $placeholders = [];
        $count = preg_match_all("(\[\[(.*)-Placeholder\]\])", $content, $placeholders);

        return $count > 0 ? array_reverse($placeholders)[0] : [];
    }
}
