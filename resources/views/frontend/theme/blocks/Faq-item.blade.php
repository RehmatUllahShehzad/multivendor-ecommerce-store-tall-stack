<div class="accordion-item" x-data="{ open: false }">
    <h2 class="accordion-header" id="flush-headingOne">
        <button class="accordion-button collapsed" x-on:click="open = !open" 
            aria-expanded="false"
            aria-controls="flush-collapseOne">
            Sample Policy
        </button>
    </h2>
    <div x-show="open" x-transition id="flush-collapseOne" class="accordion-collapse" 
        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush">
        <div data-gjs-removable="false" data-gjs-copyable="false" class="accordion-body">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam
            nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam
            erat Lorem ipsum dolor sit amet, consectetuer adipiscing .
        </div>
    </div>
</div>