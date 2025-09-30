<?php

namespace App\Livewire\SoaTable\Light;

use Closure;
use Illuminate\Database\Eloquent\Model;

class LightAction
{
    public string $foreground = 'text-indigo-500 hover:text-indigo-400';
    public string $bgBtn = 'indigo';
    public ?Closure $canSee = null;

    // >> NUEVA PROPIEDAD
    public ?Closure $execCallback = null;

    // >> CONSTRUCTOR ACTUALIZADO: $url es ahora opcional
    public function __construct(
        public string $title,
        public ?string $routeName = null
    ) {
    }

    public static function make(string $title, ?string $routeName = null): self
    {
        return new static($title, $routeName);
    }

    public function foreground(string $classes): self
    {
        $this->foreground = $classes;
        return $this;
    }

    public function bgBtn(string $bg): self
    {
        $this->bgBtn = $bg;
        return $this;
    }

    // >> NUEVO MÉTODO
    public function exec(Closure $callback): self
    {
        $this->execCallback = $callback;
        return $this;
    }

    public function canSee(Closure $callback): self
    {
        $this->canSee = $callback;
        return $this;
    }
}
