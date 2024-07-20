<?php

namespace LaraEditor\App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaraEditor\App\Editor\EditorFactory;

trait EditableTrait
{
    protected $placeholders = [];

    protected array $assets = [];

    public function setGjsDataAttribute($value)
    {
        $this->attributes['gjs_data'] = json_encode($value);
    }

    public function getHtmlAttribute()
    {
        return optional($this->gjs_data)['html'];
    }

    public function getGjsDataAttribute($value): array
    {
        return json_decode($value, true) ?? [];
    }

    public function getHtml(): string
    {
        if (! $this->html) {
            return '';
        }

        return $this->replacePlaceholders();
    }

    public function getCss(): string
    {
        return optional($this->gjs_data)['css'] ? optional($this->gjs_data)['css'] : '';
    }

    public function getPage(): array
    {
        return optional($this->gjs_data)['page'] ?? [];
    }

    public function getStyles(): array
    {
        return optional($this->gjs_data)['styles'] ?? [];
    }

    public function getStyleSheetLinks(): array
    {
        return json_decode(optional($this->gjs_data)['stylesheets'] ?? '[]');
    }

    public function getScriptLinks(): array
    {
        return json_decode(optional($this->gjs_data)['scripts'] ?? '[]');
    }

    public function getAssets(string $type = null): array
    {
        if (! $type) {
            return $this->assets;
        }

        return collect($this->assets)->only($type)->toArray();
    }

    /**
     * @var string
     * @var string js|css
     */
    public function setAsset(string $aseet, string $type = 'js')
    {
        $this->assets[$type] = $aseet;
    }

    public function setPlaceholder($placeolder, $content)
    {
        $this->placeholders[$placeolder] = $content;

        return $this;
    }

    public function getPlaceholders()
    {
        return $this->placeholders;
    }

    private function replacePlaceholders()
    {
        $processedContent = $this->html;
        foreach ($this->getPlaceholders() as $placeolder => $replaceContent) {
            $processedContent = str_replace($placeolder, $replaceContent, $processedContent);
        }

        return $processedContent;
    }

    public function saveEditorData(Request $request)
    {
        $this->gjs_data = [
            'page' => $request->json('page'),
            'styles' => $request->json('styles'),
            'css' => $request->json('css'),
            'html' => $request->json('html'),
        ];

        $this->save();

        return response()->noContent(200);
    }

    public function getEditor()
    {
        $factory = new EditorFactory();
        $editorConfig = $factory->initialize($this);

        return view('laraeditor::editor', [
            'editable' => $this,
            'editorConfig' => $editorConfig,
        ]);
    }

    public function loadBlocks(string $path, $type = 'blocks')
    {
        $templates = [];
        foreach (File::allFiles($path) as $fileInfo) {
            $templates[] = [
                'category' => $type,
                'id' => $fileInfo->getFilename(),
                'label' => Str::title(str_replace(['.blade.php', '-'], ' ', $fileInfo->getBasename())),
                'content' => $fileInfo->getContents(),
            ];
        }

        return $templates;
    }
}
