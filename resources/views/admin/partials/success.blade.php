@foreach (['success', 'error', 'warning', 'info'] as $msg)
    @if (session($msg))
        <div class="alert alert-{{ $msg === 'error' ? 'danger' : $msg }} alert-dismissible fade show" role="alert">
            {{ session($msg) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
    @endif
@endforeach
