<div {!! $attributes->merge(['class' => ' cursor-pointer text-xs font-light text-gray-400']) !!}>
    <span
        class="flex items-center space-x-1 font-bold text-red-500 hover:underline dark:text-gray-200 hover:text-red-700">
        <span>{{ $slot }}</span>
    </span>
</div>
