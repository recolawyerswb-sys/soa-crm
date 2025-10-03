<flux:badge color="{{
    match ($row->status) {
        '1' => 'green',
        '0' => 'red',
    }
}}">
    {{
        match ($row->status) {
            '1' => 'Activa',
            '0' => 'Inactiva',
            default => $row->status,
        }
    }}
</flux:badge>
