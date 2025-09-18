{{--
    Form Input Group Component
    Parameters:
    - $label: Field label text
    - $name: Field name for input
    - $type: Input type (text, email, password, tel, number, etc.) - default: text
    - $icon: Bootstrap icon name without the bi- prefix
    - $placeholder: Placeholder text
    - $value: Current value (for edit forms)
    - $required: Whether field is required
    - $disabled: Whether field is disabled
    - $errors: Laravel error bag for validation
--}}

@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'icon' => null,
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'errors' => null,
    'id' => null
])

@php
    $inputId = $id ?? $name;
    $hasError = $errors && $errors->has($name);
@endphp

<div class="form-group mb-3">
    <label for="{{ $inputId }}" class="form-label small fw-medium">
        {{ $label }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>

    @if($icon)
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-{{ $icon }} text-muted"></i>
            </span>
            <input
                class="form-control border-start-0 {{ $hasError ? 'is-invalid' : '' }}"
                type="{{ $type }}"
                name="{{ $name }}"
                id="{{ $inputId }}"
                value="{{ old($name, $value) }}"
                placeholder="{{ $placeholder }}"
                {{ $required ? 'required' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes }}
            >
        </div>
    @else
        <input
            class="form-control {{ $hasError ? 'is-invalid' : '' }}"
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes }}
        >
    @endif

    @if($hasError)
        <div class="text-danger small mt-1">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
