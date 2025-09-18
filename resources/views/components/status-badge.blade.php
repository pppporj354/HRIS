{{--
    Status Badge Component
    Parameters:
    - $status: Text to show in the badge
    - $type: Badge type (primary, secondary, success, danger, warning, info, light, dark)
    - $icon: Optional Bootstrap icon name without the bi- prefix
--}}

@props([
    'status' => '',
    'type' => 'primary',
    'icon' => null
])

<span class="badge bg-{{ $type }} bg-opacity-10 text-{{ $type }} px-3 py-2">
    @if($icon)<i class="bi bi-{{ $icon }} me-1"></i>@endif
    {{ $status }}
</span>
