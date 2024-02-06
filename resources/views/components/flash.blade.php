@if (session()->has('message'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
         class="alert alert-success "
         style="position: fixed; bottom: 0; right: 0;"
    >
        <p>
            {{ session('message') }}
        </p>
    </div>
@endif

