<form action="{{ route(config($addon->getAlias() . '.store_route')) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="addon-modal-body">
        @php
            $fields = config($addon->getAlias() . '.fields');
        @endphp
        @forelse ($fields as $name => $field)
            @php
                $value = old($name, getValueForForm($module, $name));
                
            @endphp
            <div class="addon-modal-form-row">
                <label for="email" class="addon-modal-label">{{ __($field['label']) }}
                    @if (isset($field['required']) && $field['required'])
                        <span class="addon-modal-danger">*</span>
                    @endif
                </label>
                <div class="addon-modal-field">
                    @if ($field['type'] == 'text')
                        <input type="text"
                            class="addon-modal-input {{ isset($field['class']) ? $field['class'] : '' }}"
                            placeholder="{{ $field['placeholder'] ?? $field['label'] }}" name="{{ $name }}"
                            {{ isset($field['required']) && $field['type'] ? 'required' : '' }}
                            value="{{ $value }}">
                    @elseif ($field['type'] == 'url')
                        <input type="url"
                            class="addon-modal-input {{ isset($field['class']) ? $field['class'] : '' }}"
                            placeholder="{{ $field['placeholder'] ?? $field['label'] }}" name="{{ $name }}"
                            {{ isset($field['required']) && $field['type'] ? 'required' : '' }} 
                            {{ isset($field['readonly']) && $field['type'] ? 'readonly' : '' }} 

                            value="{{ $value }}">
                    @elseif ($field['type'] == 'textarea')
                        <textarea type="text" class="addon-modal-input {{ isset($field['class']) ? $field['class'] : '' }}"
                            placeholder="{{ $field['placeholder'] ?? $field['label'] }}" name="{{ $name }}"
                            {{ isset($field['required']) && $field['type'] ? 'required' : '' }}>{{ $value ?? '' }}</textarea>
                    @elseif ($field['type'] == 'select')
                        <select class="addon-modal-input {{ isset($field['class']) ? $field['class'] : '' }}"
                            name="{{ $name }}"
                            {{ isset($field['required']) && $field['type'] ? 'required' : '' }}>
                            @forelse ($field['options'] as $option => $value)
                                <option
                                    {{ old($option, isset($module) ? $module->$name : '') == $value ? 'selected' : '' }}
                                    value="{{ $value }}">
                                    {{ $option }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    @elseif ($field['type'] == 'file')
                        <input type="file" name="{{ $name }}" id="{{ $name }}" accept="image/*" {{ isset($field['required']) && $field['type'] ? 'required' : '' }}>
                        <br>
                        <img src="{{ url('/') }}/Modules/{{ $addon->getName() }}/Resources/assets/{{ $value }}" alt="No Image" srcset="" width="200px" height="100px">
                    @endif
                    @if (isset($field['note']))
                        <span class="mt-2">
                            <span class="badge badge-info mr-2 p-1">{{ __('Note') }}</span>{{ $field['note'] }}
                        </span>
                    @endif
                </div>
            </div>
        @empty
        @endforelse
    </div>
    <div class="addon-modal-foot">
        <button class="addon-modal-submit">{{ __('Submit') }}</button>
    </div>
</form>
