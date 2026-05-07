@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-2 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl py-3 px-4 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition ease-in-out duration-150']) }}>
