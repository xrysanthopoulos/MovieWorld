<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-warning mt-3']) }}>
    {{ $slot }}
</button>
