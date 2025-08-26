<flux:badge color="{{
    match ($row->status) {
        '2' => 'yellow',
        '1' => 'green',
        '0' => 'red',
    }
}}">
    {{
        match ($row->status) {
            '2' => 'Pendiente',
            '1' => 'Aprobado',
            '0' => 'Rechazado',
            default => $row->status,
        }
    }}
</flux:badge>
