@props([
    'title' => null,
])

<x-layouts::dashboard :title="$title ?? __('Dashboard')" :subtitle="__('Administration')" :dark="true">
    <x-slot:brandBadge>
        <span class="ml-auto inline-flex items-center rounded-full bg-brand-500/20 px-2 py-0.5 text-[11px] font-semibold text-brand-300">{{ __('Administration') }}</span>
    </x-slot:brandBadge>

    <x-slot:navigation>
        <a href="{{ route('admin.dashboard') }}" @class([
            'flex items-center gap-3 rounded-lg border-l-2 px-3 py-2 text-sm font-medium',
            'border-brand-500 bg-white/5 text-white' => request()->routeIs('admin.dashboard'),
            'border-transparent text-stone-300 hover:bg-white/5 hover:text-white' => ! request()->routeIs('admin.dashboard'),
        ])>
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.122 0L22.28 12M4.5 9.75V19.5a1.5 1.5 0 001.5 1.5h3.75v-6h4.5v6h3.75a1.5 1.5 0 001.5-1.5V9.75"/></svg>
            {{ __('Dashboard') }}
        </a>
        <a href="{{ route('admin.species.index') }}" @class([
            'flex items-center gap-3 rounded-lg border-l-2 px-3 py-2 text-sm font-medium',
            'border-brand-500 bg-white/5 text-white' => request()->routeIs('admin.species.*'),
            'border-transparent text-stone-300 hover:bg-white/5 hover:text-white' => ! request()->routeIs('admin.species.*'),
        ])>
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
            {{ __('Species') }}
        </a>
        <a href="{{ route('admin.families.index') }}" @class([
            'flex items-center gap-3 rounded-lg border-l-2 px-3 py-2 text-sm font-medium',
            'border-brand-500 bg-white/5 text-white' => request()->routeIs('admin.families.*'),
            'border-transparent text-stone-300 hover:bg-white/5 hover:text-white' => ! request()->routeIs('admin.families.*'),
        ])>
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
            {{ __('Families') }}
        </a>
        <a href="{{ route('admin.users.index') }}" @class([
            'flex items-center gap-3 rounded-lg border-l-2 px-3 py-2 text-sm font-medium',
            'border-brand-500 bg-white/5 text-white' => request()->routeIs('admin.users.*'),
            'border-transparent text-stone-300 hover:bg-white/5 hover:text-white' => ! request()->routeIs('admin.users.*'),
        ])>
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
            {{ __('Users') }}
        </a>
        <a href="{{ url(config('horizon.path')) }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-lg border-l-2 border-transparent px-3 py-2 text-sm font-medium text-stone-300 hover:bg-white/5 hover:text-white">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
            {{ __('Queues') }}
            <svg class="ml-auto h-3.5 w-3.5 text-stone-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
        </a>
    </x-slot:navigation>

    <x-slot:sidebarFooter>
        <div class="flex items-center gap-3 rounded-lg px-2 py-2">
            <span class="flex h-9 w-9 flex-none items-center justify-center rounded-full bg-brand-500/20 text-sm font-semibold text-brand-300">{{ auth()->user()->initials() }}</span>
            <div class="min-w-0">
                <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                <p class="truncate text-xs text-stone-400">{{ __('administrator') }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mt-2 flex w-full items-center gap-3 rounded-lg px-2 py-2 text-sm text-stone-400 hover:bg-white/5 hover:text-white">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3"/></svg>
                {{ __('Log out') }}
            </button>
        </form>
    </x-slot:sidebarFooter>

    <x-slot:actions>
        <details class="relative">
            <summary class="flex h-9 w-9 list-none items-center justify-center rounded-lg text-stone-600 hover:bg-stone-100 [&::-webkit-details-marker]:hidden">
                            <span class="relative">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                                <span class="absolute -right-0.5 -top-0.5 h-2 w-2 rounded-full bg-red-500"></span>
                            </span>
            </summary>
            <div class="absolute right-0 z-20 mt-2 w-72 rounded-xl border border-stone-200 bg-white p-2 shadow-lg">
                <p class="px-2 py-1.5 text-xs font-semibold uppercase tracking-wide text-stone-400">{{ __('Notifications') }}</p>
                <a href="#" class="flex items-start gap-3 rounded-lg px-2 py-2 hover:bg-stone-50">
                    <span class="mt-1 h-2 w-2 flex-none rounded-full bg-brand-600"></span>
                    <span><span class="block text-sm text-stone-800">{{ __(':count new users registered', ['count' => 3]) }}</span><span class="block text-xs text-stone-500">{{ __('Today') }}</span></span>
                </a>
                <a href="#" class="flex items-start gap-3 rounded-lg px-2 py-2 hover:bg-stone-50">
                    <span class="mt-1 h-2 w-2 flex-none rounded-full bg-stone-300"></span>
                    <span><span class="block text-sm text-stone-800">{{ __('Species catalogue updated') }}</span><span class="block text-xs text-stone-500">{{ __('Yesterday') }}</span></span>
                </a>
            </div>
        </details>

        <details class="relative">
            <summary class="flex list-none items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-stone-100 [&::-webkit-details-marker]:hidden">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-stone-200 text-xs font-semibold text-stone-700">{{ auth()->user()->initials() }}</span>
                <svg class="h-4 w-4 text-stone-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
            </summary>
            <div class="absolute right-0 z-20 mt-2 w-52 rounded-xl border border-stone-200 bg-white p-1.5 shadow-lg">
                <a href="#" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-stone-50">{{ __('Profile') }}</a>
                <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-stone-50">{{ __('Back to the application') }}</a>
                <div class="my-1 border-t border-stone-200"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50">{{ __('Log out') }}</button>
                </form>
            </div>
        </details>
    </x-slot:actions>

    {{ $slot }}

    <livewire:confirm-modal />

</x-layouts::dashboard>
