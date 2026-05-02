<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => '
        inline-flex items-center justify-center
        px-6 py-3
        bg-[#789744]
        border border-transparent
        rounded-full
        font-bold
        text-base
        text-white
        tracking-normal
        hover:bg-[#6A873B]
        active:bg-[#5E7834]
        focus:outline-none
        focus:ring-2
        focus:ring-[#789744]
        focus:ring-offset-2
        transition
        ease-in-out
        duration-150
    '
]) }}>
    {{ $slot }}
</button>