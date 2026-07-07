@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#a01a1d] focus:ring-[#a01a1d] rounded-md shadow-sm']) }}>
