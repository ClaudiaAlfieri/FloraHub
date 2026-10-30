<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ $family->name }}</title>
    {{-- dompdf does not support Tailwind, flex or grid: simple CSS and tables only. --}}
    <style>
        @page { margin: 32px 40px 56px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #292524; }
        h1 { margin: 0; font-size: 24px; color: #2b3b25; }
        h2 { margin: 24px 0 8px; font-size: 14px; color: #3c5632; border-bottom: 1px solid #cddcc2; padding-bottom: 4px; }
        .brand { font-size: 10px; font-weight: bold; color: #4a6b3d; text-transform: uppercase; letter-spacing: 1px; }
        .removed { display: inline-block; margin-left: 8px; padding: 2px 6px; border-radius: 4px; background: #fef2f2; color: #b91c1c; font-size: 10px; }
        .muted { color: #78716c; }
        .image { width: 100%; max-height: 260px; margin-top: 16px; border-radius: 8px; }
        .description { line-height: 1.5; white-space: pre-line; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #4a6b3d; color: #ffffff; text-align: left; padding: 6px 8px; font-size: 10px; }
        td { padding: 6px 8px; border-bottom: 1px solid #e7e5e4; }
        tr:nth-child(even) td { background: #f4f7f2; }
        .scientific { font-style: italic; }
        footer { position: fixed; bottom: -32px; left: 0; right: 0; font-size: 9px; color: #78716c; text-align: center; }
    </style>
</head>
<body>
<footer>{{ __('FloraHub · Generated on :date', ['date' => now()->format('d/m/Y H:i')]) }}</footer>

<p class="brand">FloraHub · {{ __('Botanical family') }}</p>

<h1>
    {{ $family->name }}
    @if ($family->trashed())
        <span class="removed">{{ __('Removed') }}</span>
    @endif
</h1>

@if ($imagePath)
    <img class="image" src="{{ $imagePath }}" alt="{{ $family->name }}">
@endif

<h2>{{ __('Description') }}</h2>
<p class="description">{{ $family->description ?? __('No description.') }}</p>

<h2>{{ __('Species') }} ({{ $species->count() }})</h2>

@if ($species->isEmpty())
    <p class="muted">{{ __('This family has no species.') }}</p>
@else
    <table>
        <thead>
        <tr>
            <th>{{ __('Scientific name') }}</th>
            <th>{{ __('Common name') }}</th>
            <th>{{ __('Watering') }}</th>
            <th>{{ __('Light exposure') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($species as $item)
            <tr>
                <td class="scientific">{{ $item->scientific_name }}</td>
                <td>{{ $item->common_name }}</td>
                <td>{{ $item->watering->label() }}</td>
                <td>{{ $item->light->label() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
</body>
</html>
