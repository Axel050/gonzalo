@props(['active' => false,'route'=>"" ])

<li class="mb-2 py-0.5 hover:text-gray-300 px-0.5 rounded-lg pl-2 hover:bg-cyan-900 hover:shadow-md hover:shadow-cyan-700 text-gray-300 text-sm
    {{ $active ? 'bg-linear-to-l from-cyan-700 to-cyan-950 text-gray-300 font-bold' : '' }}"
    {{ $attributes }}>
      <a class="flex gap-x-2 " href="{{ $route ? Route($route) : '#' }}">    
    {{ $slot }}
    </a>
</li>