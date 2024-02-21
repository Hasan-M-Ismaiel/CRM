@if (session()->has('message'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
         class="alert alert-success "
         style="position: fixed; bottom: 15; right: 90;"
    >
        <p>
            {{ session('message') }}
        </p>
    </div>
@endif

