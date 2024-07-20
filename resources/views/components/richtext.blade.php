<div
    x-ref="input"
    x-data="{
        value: @entangle($attributes->wire('model')),
        init() {
          {{ $instanceId }} = new Quill($refs.editor, {
            theme: 'snow'
          })

          {{ $instanceId }}.on('text-change', () => {
            $dispatch('quill-input', {{ $instanceId }}.root.innerHTML)
          })
        }
    }"
    x-on:quill-input="value = $event.detail"
    wire:ignore
>
  <div>
      <div x-ref="editor">{!! $initialValue !!}</div>
  </div>
</div>

@pushOnce('pre_alpine_js')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endPushOnce

@pushOnce('page_css')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endPushOnce