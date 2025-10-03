<?php

namespace App\Livewire\Sells\Calls;

use Livewire\Component;
use Twilio\Rest\Client;

class CallHistory extends Component
{
    public $calls = [];
    public $pageSize = 10; // Número de llamadas por página

    // Propiedades para manejar la paginación de Twilio
    public $nextPageSid = null;
    public $previousPageSid = null;

    public function mount()
    {
        $this->loadCalls();
    }

    public function loadCalls($pageSid = '')
    {
        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));

        try {
            // Pasamos el SID de la página que queremos cargar
            $page = $twilio->calls->page([], $this->pageSize, $pageSid);

            // dd($page);

            // Guardamos los identificadores para los botones de paginación
            $this->nextPageSid = $this->extractSidFromUrl($page->getNextPageUrl());
            $this->previousPageSid = $this->extractSidFromUrl($page->getPreviousPageUrl());

            $this->calls = collect($page)->map(function($call) {
                return [
                    'from' => $call->fromFormatted,
                    'to' => $call->toFormatted,
                    'status' => $call->status,
                    'start_time' => $call->startTime,
                    'end_time' => $call->endTime,
                    'duration' => $call->duration,
                    'caller_name' => $call->callerName,
                    'answered_by' => $call->answeredBy,
                ];
            })->toArray();

        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo cargar el historial de llamadas.');
            $this->calls = [];
        }
    }

    // Métodos para la paginación
    public function nextPage()
    {
        $this->loadCalls($this->nextPageSid);
    }

    public function previousPage()
    {
        $this->loadCalls($this->previousPageSid);
    }

    // Helper para extraer el SID de la URL de paginación de Twilio
    private function extractSidFromUrl($url)
    {
        if (!$url) return null;
        parse_str(parse_url($url, PHP_URL_QUERY), $queryParams);
        return $queryParams['PageToken'] ?? null;
    }

    public function placeholder()
    {
        return view('livewire.placeholders.sells.call-history');
    }

    public function render()
    {
        return view('livewire.sells.calls.call-history');
    }
}
