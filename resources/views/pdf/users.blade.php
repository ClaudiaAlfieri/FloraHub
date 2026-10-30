<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('Users report') }}</title>
    {{-- dompdf does not support Tailwind, flex or grid: simple CSS and tables only. --}}
    <style>
        @page { margin: 32px 40px 56px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #292524; }
        h1 { margin: 0; font-size: 22px; color: #2b3b25; }
        .brand { font-size: 10px; font-weight: bold; color: #4a6b3d; text-transform: uppercase; letter-spacing: 1px; }
        .muted { margin: 4px 0 16px; color: #78716c; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #4a6b3d; color: #ffffff; text-align: left; padding: 6px; font-size: 9px; }
        td { padding: 6px; border-bottom: 1px solid #e7e5e4; }
        tr:nth-child(even) td { background: #f4f7f2; }
        footer { position: fixed; bottom: -32px; left: 0; right: 0; font-size: 9px; color: #78716c; text-align: center; }
    </style>
</head>
<body>
<footer>{{ __('FloraHub · Generated on :date', ['date' => now()->format('d/m/Y H:i')]) }} · {{ __('Confidential: contains personal data.') }}</footer>

<p class="brand">FloraHub · {{ __('Administration') }}</p>
<h1>{{ __('Users report') }}</h1>
<p class="muted">{{ trans_choice(':count user|:count users', $users->count(), ['count' => $users->count()]) }}</p>

<table>
    <thead>
    <tr>
        <th>{{ __('Name') }}</th>
        <th>{{ __('Email') }}</th>
        <th>{{ __('Role') }}</th>
        <th>{{ __('Registered on') }}</th>
        <th>{{ __('Verified') }}</th>
        <th>{{ __('2FA') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->hasRole('admin') ? __('Administrator') : __('User') }}</td>
            <td>{{ $user->created_at?->format('d/m/Y') }}</td>
            <td>{{ $user->email_verified_at !== null ? __('Yes') : __('No') }}</td>
            <td>{{ $user->two_factor_confirmed_at !== null ? __('Yes') : __('No') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
