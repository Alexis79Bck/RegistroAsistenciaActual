@if (session('mensaje'))
    <div class="alert alert-success alert-dismissible fade show w-50 float-right" role="alert" id="alert-box">
        <i class="fas fa-info-circle"></i> {{ session('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('mensaje-error'))
    <div class="alert alert-danger alert-dismissible fade show w-50 float-right" role="alert" id="alert-box">
        <i class="fas fa-times-circle"></i> {{ session('mensaje-error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('mensaje-advertencia'))
    <div class="alert alert-warning alert-dismissible fade show w-50 float-right" role="alert" id="alert-box">
        <i class="fas fa-exclamation-circle"></i> {{ session('mensaje-advertencia') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
