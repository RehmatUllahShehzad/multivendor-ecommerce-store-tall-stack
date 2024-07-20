<script>
    toastr.options = Object.assign({}, toastr.options || {}, {
        closeButton: true
    });
    
    @if (session()->has('alert-success'))
        toastr.success('{{ session('alert-success') }}')
    @endif

    @if (session()->has('alert-danger'))
        toastr.error('{{ session('alert-danger') }}')
    @endif

    @if (session()->has('alert-info'))
        toastr.info('{{ session('alert-info') }}')
    @endif

    @if (session()->has('alert-warning'))
        toastr.warning('{{ session('alert-warning') }}')
    @endif
</script>
