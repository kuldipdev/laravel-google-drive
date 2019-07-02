@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" style="color: red;">
        {{ session('error') }}
    </div>
@endif
