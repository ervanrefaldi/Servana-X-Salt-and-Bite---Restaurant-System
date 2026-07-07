<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#a01a1d] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#8b0000] focus:bg-[#8b0000] active:bg-[#6b0000] focus:outline-none focus:ring-2 focus:ring-[#a01a1d] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
