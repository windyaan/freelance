@props(['label', 'name', 'type' => 'text'])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm text-gray-700">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" {{ $attributes }}
        class="mt-1 w-full border-b border-gray-300 focus:outline-none focus:border-purple-700 py-2 placeholder-gray-400" />
</div>
