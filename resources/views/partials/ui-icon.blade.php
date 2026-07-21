@php
    $iconName = $name ?? 'circle';
    $iconClass = $class ?? '';
    $icons = [
        'home' => '<path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/><path d="M9.5 21v-6h5v6"/>',
        'patient' => '<path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/><path d="M4 21a8 8 0 0 1 16 0"/><path d="M19 8v4"/><path d="M17 10h4"/>',
        'assessment' => '<path d="M9 3h6l1 2h3v16H5V5h3l1-2Z"/><path d="m9 13 2 2 4-5"/><path d="M9 18h6"/>',
        'result' => '<path d="M4 19V5"/><path d="M4 19h16"/><path d="m7 15 4-4 3 3 5-7"/>',
        'book' => '<path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v17H6.5A2.5 2.5 0 0 0 4 22V5.5Z"/><path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20"/><path d="M8 7h7"/>',
        'family' => '<path d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M16 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M2 21a6 6 0 0 1 12 0"/><path d="M10 21a6 6 0 0 1 12 0"/>',
        'content' => '<path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/><path d="M7 13h10"/><path d="M7 16h7"/>',
        'settings' => '<path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z"/><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.05.05a2 2 0 1 1-2.83 2.83l-.05-.05A1.7 1.7 0 0 0 15 19.4a1.7 1.7 0 0 0-1 1.55V21a2 2 0 1 1-4 0v-.05a1.7 1.7 0 0 0-1-1.55 1.7 1.7 0 0 0-1.88.34l-.05.05a2 2 0 1 1-2.83-2.83l.05-.05A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.55-1H3a2 2 0 1 1 0-4h.05A1.7 1.7 0 0 0 4.6 9a1.7 1.7 0 0 0-.34-1.88l-.05-.05a2 2 0 1 1 2.83-2.83l.05.05A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-1.55V3a2 2 0 1 1 4 0v.05a1.7 1.7 0 0 0 1 1.55 1.7 1.7 0 0 0 1.88-.34l.05-.05a2 2 0 1 1 2.83 2.83l-.05.05A1.7 1.7 0 0 0 19.4 9a1.7 1.7 0 0 0 1.55 1H21a2 2 0 1 1 0 4h-.05A1.7 1.7 0 0 0 19.4 15Z"/>',
        'question' => '<path d="M9.1 9a3 3 0 1 1 5.8 1c-.6 1.5-2.4 1.8-2.8 3.3"/><path d="M12 17h.01"/><circle cx="12" cy="12" r="9"/>',
        'landing' => '<path d="M4 5h16v14H4z"/><path d="M8 9h8"/><path d="M8 13h5"/><path d="m15 15 2 2 3-4"/>',
        'booklet' => '<path d="M5 4h10a4 4 0 0 1 4 4v12H9a4 4 0 0 0-4-4V4Z"/><path d="M5 16a4 4 0 0 1 4 4"/><path d="M9 8h6"/><path d="M9 12h5"/>',
        'report' => '<path d="M7 3h7l5 5v13H7V3Z"/><path d="M14 3v6h5"/><path d="M10 14h6"/><path d="M10 18h4"/>',
        'users' => '<path d="M16 11a4 4 0 1 0-8 0"/><path d="M5 21a7 7 0 0 1 14 0"/><path d="M17 7a3 3 0 0 1 3 3"/><path d="M20 21a5 5 0 0 0-3-4.5"/><path d="M7 7a3 3 0 0 0-3 3"/><path d="M4 21a5 5 0 0 1 3-4.5"/>',
        'logout' => '<path d="M10 17 15 12l-5-5"/><path d="M15 12H3"/><path d="M21 3v18h-7"/>',
        'check' => '<path d="m5 12 4 4L19 6"/><circle cx="12" cy="12" r="9"/>',
        'alert' => '<path d="M12 3 2.5 20h19L12 3Z"/><path d="M12 9v5"/><path d="M12 17h.01"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m16 16 5 5"/>',
        'circle' => '<circle cx="12" cy="12" r="9"/>',
    ];
@endphp

<svg class="ui-icon {{ $iconClass }}" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
    {!! $icons[$iconName] ?? $icons['circle'] !!}
</svg>
