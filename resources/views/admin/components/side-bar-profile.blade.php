<div class="flex flex-shrink-0 p-4 bg-white border-t border-gray-200 dark:bg-gray-800">
   
        <div class="flex items-center">
            <div>
                <div>
                    <img src="{{ auth()->user()->profileImage }}" class="inline-block w-10 h-10 rounded-full">
                </div>
            </div>
            <div class="ml-3">
                <div class="w-32 text-sm font-medium text-gray-700 truncate dark:text-gray-50 group-hover:text-gray-900 dark:group-hover:text-gray-50">
                    <a href="{{route('admin.staff.profile')}}" class="flex-shrink-0 block group">{{ auth()->user()->name }}</a>
                </div>
                {{-- <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-50">
                    View profile
                </p> --}}
            </div>
            <div class="pl-2">
                <livewire:admin.auth.logout-controller :isSideBar="true" />
            </div>
        </div>
    
</div>