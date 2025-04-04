<x-layouts.app :title="__('Dashboard')">
  <x-slot name="headerT">
    Dashboard
  </x-slot>      
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl ">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-cyan-600 ">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-cyan-900/70 " />                
                
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 ">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-cyan-900/70 " />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-amber-900">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-cyan-900/70 " />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-fuchsia-900">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-cyan-900/70 " />
            MENU
        </div>
    </div>
</x-layouts.app>
