<?php

namespace App\Livewire\Forms\Business\Teams;

use App\Livewire\Forms\CustomTranslatedForm;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class CreateTeamForm extends CustomTranslatedForm
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|max:255')]
    public $description = '';

    #[Validate('required|string|max:80')]
    public $slogan = '';

    #[Validate('required|string|max:12')]
    public $color_code = '';

    public function save(bool $isEditEnabled = false, int $teamId = null)
    {
        $this->validate();

        DB::transaction(function () use ($isEditEnabled, $teamId) {
            if ($isEditEnabled) {
                // --- UPDATE ---
                $team = Team::findOrFail($teamId);

                $team->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'slogan' => $this->slogan,
                    'color_code' => $this->color_code,
                ]);

            } else {
                $team = Team::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'slogan' => $this->slogan,
                    'color_code' => $this->color_code,
                ]);
            }
        });

        $this->reset();
    }
}
