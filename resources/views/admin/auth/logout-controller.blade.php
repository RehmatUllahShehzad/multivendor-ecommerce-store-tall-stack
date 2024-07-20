<div class="w-full">
    <form wire:submit.prevent="logout">
        <button id="sidebar-button" wire:loading.remove wire:target="logout">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 11V13L17 13V16L22 12L17 8V11L8 11Z" fill="#9A9AA9"></path>
                <path d="M4 21H13C14.103 21 15 20.103 15 19V15H13V19H4L4 5H13V9H15V5C15 3.897 14.103 3 13 3H4C2.897 3 2 3.897 2 5L2 19C2 20.103 2.897 21 4 21Z" fill="#9A9AA9"></path>
            </svg>
        </button>
        <i class="las la-circle-notch la-spin text-xl leading-none dark:text-gray-50" wire:loading wire:target="logout"></i>
    </form>
</div>
