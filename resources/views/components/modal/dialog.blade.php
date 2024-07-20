<x-modal {{ $attributes }}>
    <div class="modal-content">
        <div class="review-modal">
            @if ($form)
                <form @submit.prevent="{{ $form }}">
            @endif
            <div class="px-6 py-4">
                <div class="text-lg">
                    {{ $title }}
                </div>

                <div class="mt-4">
                    {{ $content }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    {{ $footer }}
                </div>
            </div>
            @if ($form)
                </form>
            @endif
        </div>
    </div>
</x-modal>
