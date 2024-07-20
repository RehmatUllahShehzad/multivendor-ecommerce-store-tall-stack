<div class="overflow-hidden border border-gray-200 dark:border-none shadow sm:rounded-lg">
  {{ $toolbar ?? null }}
  <div class="w-full overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
        <tr class="dark:border-transparent dark:border-none">
          {{ $head }}
        </tr>
      </thead>

      <tbody {{ $attributes->wire('sortable') }} @if($attributes->get('row-ref')) x-ref="{{ $attributes->get('row-ref') }}" @endif class="relative">
        {{ $body }}
      </tbody>
    </table>
  </div>
</div>
