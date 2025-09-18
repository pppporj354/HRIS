{{--
    DataTable Action Button Component
    Parameters:
    - $type: Type of button (primary, secondary, success, danger, warning, info, light, dark)
    - $icon: Bootstrap icon name without the bi- prefix
    - $label: Button label
    - $id: Optional ID for the button
    - $modal: Optional ID of modal to toggle
    - $href: Optional href for links
    - $form: Optional form ID for submitting forms
    - $tooltip: Optional tooltip text
    - $permission: Optional permission check
--}}

@props([
    'type' => 'primary',
    'icon' => null,
    'label' => '',
    'id' => null,
    'modal' => null,
    'href' => null,
    'form' => null,
    'tooltip' => null,
    'permission' => null
])

@if(!$permission || auth()->user()->can($permission))
    @if($href)
        <a href="{{ $href }}"
           id="{{ $id }}"
           @if($tooltip) data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $tooltip }}" @endif
           @if($modal) data-bs-toggle="modal" data-bs-target="#{{ $modal }}" @endif
           class="btn btn-{{ $type }} {{ $tooltip ? 'tooltip-action' : '' }} {{ isset($attributes['class']) ? $attributes['class'] : '' }}"
           {{ $attributes }}
        >
            @if($icon)<i class="bi bi-{{ $icon }} {{ $label ? 'me-1' : '' }}"></i>@endif{{ $label }}
        </a>
    @elseif($form)
        <button type="submit"
                form="{{ $form }}"
                id="{{ $id }}"
                @if($tooltip) data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $tooltip }}" @endif
                class="btn btn-{{ $type }} {{ $tooltip ? 'tooltip-action' : '' }} {{ isset($attributes['class']) ? $attributes['class'] : '' }}"
                {{ $attributes }}
        >
            @if($icon)<i class="bi bi-{{ $icon }} {{ $label ? 'me-1' : '' }}"></i>@endif{{ $label }}
        </button>
    @else
        <button type="button"
                id="{{ $id }}"
                @if($tooltip) data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $tooltip }}" @endif
                @if($modal) data-bs-toggle="modal" data-bs-target="#{{ $modal }}" @endif
                class="btn btn-{{ $type }} {{ $tooltip ? 'tooltip-action' : '' }} {{ isset($attributes['class']) ? $attributes['class'] : '' }}"
                {{ $attributes }}
        >
            @if($icon)<i class="bi bi-{{ $icon }} {{ $label ? 'me-1' : '' }}"></i>@endif{{ $label }}
        </button>
    @endif
@endif
