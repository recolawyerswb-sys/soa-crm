<flux:badge color="{{
    match ($row->type) {
        '1' => 'green',
        '2' => 'red',
        '3' => 'indigo',
    }
}}">
    {{
        match ($row->type) {
            '1' => 'Deposito',
            '2' => 'Retiro',
            '3' => 'Bono',
            default => $row->type,
        }
    }}
</flux:badge>
