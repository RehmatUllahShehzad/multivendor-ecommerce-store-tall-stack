<li class="relative px-6 py-3">
    @if ($item->isActive($component->attributes->get('current')))
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a
        href="{{ route($item->route) }}"
        class="flex items-center px-3 py-2 text-sm font-medium @if (!$item->isActive($component->attributes->get('current'))) text-gray-900 hover:text-gray-900 hover:bg-gray-50 @else bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white @endif rounded-md  group"
        aria-current="page">
        <span class="@if (!$item->isActive($component->attributes->get('current'))) text-gray-400 group-hover:text-gray-500 @else text-indigo-500 group-hover:text-indigo-500 @endif">
            {!! $item->renderIcon('flex-shrink-0 w-6 h-6 mr-3 -ml-1') !!}
        </span>
        <span class="truncate">
            {{ $item->name }}
        </span>
    </a>
</li>
