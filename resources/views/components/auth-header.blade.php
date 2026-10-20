@props([
    'title',
    'description',
])

<div class="flex w-full flex-col">
    <h1 class="text-2xl font-semibold tracking-tight text-stone-900">{{ $title }}</h1>
    <p class="mt-1.5 text-sm text-stone-500">{{ $description }}</p>
</div>
