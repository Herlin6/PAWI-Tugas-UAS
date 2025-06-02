@props(['messages'])

@if ($messages)
    @foreach ((array) $messages as $message)
        <div class="font-playfair sub-title-color">{{ $message }}</div>
    @endforeach
@endif
