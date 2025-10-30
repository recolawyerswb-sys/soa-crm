<flux:badge color="{{
    match ($row->status) {
        '2' => 'orange',
        '1' => 'green',
        '0' => 'red',
    }
}}">
    {{
        match ($row->status) {
            '2' => 'Suspendido',
            '1' => 'Activo',
            '0' => 'Inactivo',
            default => $row->status,
        }
    }}
</flux:badge>
