{{--
    Form Section Component
    Parameters:
    - $title: Section title
    - $icon: Bootstrap icon name without the bi- prefix
    - $color: Color class for the section (primary, secondary, success, etc.)
--}}

@props([
    'title' => '',
    'icon' => null,
    'color' => 'primary'
])

<div class="form-section mb-3">
    <h6 class="text-{{ $color }} fw-semibold mb-3">
        @if($icon)
            <i class="bi bi-{{ $icon }} me-2"></i>
        @endif
        {{ $title }}
    </h6>
    {{ $slot }}
</div>
