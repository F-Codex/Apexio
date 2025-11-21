@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success small fw-medium mb-4']) }} role="alert">
        {{ $status }}
    </div>
@endif