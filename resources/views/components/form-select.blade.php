{{--
    Form Select Component
    Parameters:
    - $label: Field label text
    - $name: Field name for select
    - $options: Array of options with key => value
    - $icon: Bootstrap icon name without the bi- prefix
    - $value: Current selected value
    - $required: Whether field is required
    - $disabled: Whether field is disabled
    - $placeholder: Placeholder option text
    - $errors: Laravel error bag for validation
--}}

@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'icon' => null,
    'value' => '',
    'required' => false,
    'disabled' => false,
    'placeholder' => 'Pilih...',
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
            <select
                class="form-control border-start-0 {{ $hasError ? 'is-invalid' : '' }}"
                name="{{ $name }}"
                id="{{ $inputId }}"
                {{ $required ? 'required' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes }}
            >
                @if($placeholder)
                    <option value="">{{ $placeholder }}</option>
                @endif
                @foreach($options as $key => $option)
                    <option value="{{ $key }}" {{ (old($name, $value) == $key) ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        </div>
    @else
        <select
            class="form-control {{ $hasError ? 'is-invalid' : '' }}"
            name="{{ $name }}"
            id="{{ $inputId }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes }}
        >
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            @foreach($options as $key => $option)
                <option value="{{ $key }}" {{ (old($name, $value) == $key) ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        </select>
    @endif

    @if($hasError)
        <div class="text-danger small mt-1">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
