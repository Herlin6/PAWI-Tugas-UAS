<div {{ $attributes->merge(['class' => 'font-playfair main-color']) }}>
    <div class="text-start border border-gold rounded p-4 bg-body-secondary h-100">
        {{ $slot }}
    </div>
</div>
