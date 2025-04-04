@props(['active' => false,'route'=>"" ])

<li class="mb-2 py-1 hover:text-gray-200 px-1 rounded-lg pl-2 hover:bg-cyan-900 hover:shadow-md hover:shadow-cyan-700 
    {{ $active ? 'bg-linear-to-r from-cyan-700 to-cyan-950 text-gray-200 font-bold' : '' }}"
    {{ $attributes }}>
      <a class="flex gap-x-2" href="{{ $route ? Route($route) : '#' }}">    
    {{ $slot }}
    </a>
</li>