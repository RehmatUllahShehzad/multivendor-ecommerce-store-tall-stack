<div x-data="{
    showModal: false
}"

@showmodal.window="showModal=true"
@hidemodal.window="showModal=false"
>

    <div class="popup">
        <div class="modal fade" :class="showModal ? 'show d-block' : '' " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content p-sm-4 p-2">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-white" id="staticBackdropLabel">{{ $title }}</h5>
                        <button type="button" @click="showModal=false" class="btn-close position-absolute top-0 start-100 translate-middle m-0 text-white rounded-circle border border-2" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body pt-0">
                        @if ($form)
                            <form wire:submit.prevent="{{ $form }}">
                        @endif
                        {{ $content }}
                        @if ($form)
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade" :class="showModal ? 'show d-block' : 'd-none' "></div>
</div>
