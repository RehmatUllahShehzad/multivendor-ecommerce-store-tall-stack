<div>
    <header class="flex items-center">
        <h1 class="text-lg font-bold text-gray-900 md:text-2xl">
            <span class="text-gray-500">Form Detail</span>
        </h1>
    </header>
    <div class="mt-4">
        <ul class="space-y-4">
            <li class="text-sm bg-white borderborder-green-300 rounded-lg shadow-sm ">
                <div class="grid grid-cols-2 gap-4 p-3">
                    <div class="...">
                        <div>
                            <strong class="text-xs text-gray-500">
                                <strong>First Name: </strong>
                                {{ $form->first_name }}
                            </strong>
                        </div>
                    </div>
                    <div class="...">
                        <div>
                            <strong class="text-xs text-gray-500">
                                <strong>Last Name: </strong>
                                {{ $form->last_name }}
                            </strong>
                        </div>
                    </div>
                    <div class="...">
                        <div>
                            <strong class="text-xs text-gray-500">
                                <strong>Email: </strong>
                                {{ $form->email }}
                            </strong>
                        </div>
                    </div>
                    @foreach ($form->extra_data as $key => $value)
                        <div class="...">
                            <div>
                                <strong class="text-xs text-gray-500">
                                    <strong>{{ Str::of($key)->replace('_', ' ')->title() }}: </strong>
                                    {{ $value }}
                                </strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </li>
        </ul>
    </div>

</div>
