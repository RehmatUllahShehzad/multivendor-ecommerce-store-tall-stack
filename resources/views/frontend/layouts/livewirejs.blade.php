<script>
    window.addEventListener("DOMContentLoaded", function() {
        window.livewire.on("alert-success", function(e) {
            toastr.success(e)
        }), window.livewire.on("alert-info", function(e) {
            toastr.info(e)
        }), window.livewire.on("alert-warning", function(e) {
            toastr.warning(e)
        }), window.livewire.on("alert-danger", function(e) {
            toastr.error(e)
        }), window.livewire.on("confirmDelete", function(e) {
            confirm("Are you sure to delete this record ?") && (window
                .livewire.emit("delete", e))
        })
    });
</script>
