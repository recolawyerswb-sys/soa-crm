@if ($row->profile->user->is_online)
    <span class="status-circle online" title="En línea"></span>
@else
    <span class="status-circle offline" title="Desconectado"></span>
@endif
