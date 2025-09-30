<?php

namespace App\Livewire\Modals\Generic;

use Livewire\Attributes\On;
use Livewire\Component;

class ConfirmationModal extends Component
{
    public ?string $actionTitleName = '';
    public ?string $actionBtnLabel = '';
    public ?string $actionEventName = '';
    public ?string $targetId = '';

    #[On('fill-confirmation-modal-props')]
    public function fillConfirmationModalProps(
        array $data,
        string $targetId,
    ): void {
        $this->actionTitleName = $data['actionTitleName'];
        $this->actionBtnLabel = $data['actionBtnLabel'];
        $this->actionEventName = $data['actionEventName'];
        $this->targetId = $targetId;
    }

    public function placeholder()
    {
        return view('livewire.placeholders.confirm-modal-skeleton');
    }

    public function render()
    {
        return view('livewire.modals.generic.confirmation-modal');
    }
}
