<?php

namespace App\Livewire\SoaTable\Light;

use Closure;

class LightColumn
{
    public bool $sortable = false;
    public bool $isBadge = false;
    public string $badgeColor = 'primary';
    public ?Closure $canSee = null;

    // >> CURRENCY FORMATTER PROPS
    public bool $isCurrency = false;
    public string $currencySymbol = '$';
    public int $currencyDecimals = 2;

    // >> DATE FORMATTER PROPS
    public bool $isDate = false;
    public string $dateFormat = 'M, d';

    // >> NUEVA PROPIEDAD: Para guardar el callback dinámico
    public ?Closure $badgeResolver = null;

    public function __construct(
        public string $label,
        public string $field
    ) {
    }

    public static function make(string $label, string $field): self
    {
        return new static($label, $field);
    }

    public function sortable(): self
    {
        $this->sortable = true;
        return $this;
    }

    /**
     * >> MÉTODO ACTUALIZADO: Acepta un string o un Closure
     *
     * @param string|Closure $colorOrResolver Un color estático o un callback para lógica dinámica.
     */
    public function badge(string|Closure $colorOrResolver = 'primary'): self
    {
        $this->isBadge = true;

        if (is_callable($colorOrResolver)) {
            // Si es un callback, lo guardamos para resolverlo en la vista.
            $this->badgeResolver = $colorOrResolver;
        } else {
            // Si es un string, lo usamos como color estático.
            $this->badgeColor = $colorOrResolver;
        }

        return $this;
    }

    public function canSee(Closure $callback): self
    {
        $this->canSee = $callback;
        return $this;
    }

    /**
     *
     * Formats the column as currency.
     *
     * @param string $symbol The currency symbol.
     * @param int $decimals The number of decimal places.
     * @return self
     */
    public function currency(string $symbol = '$', int $decimals = 2): self
    {
        $this->isCurrency = true;
        $this->currencySymbol = $symbol;
        $this->currencyDecimals = $decimals;
        return $this;
    }

    /**
     * >> Add this new method
     *
     * Formats the column as a date.
     *
     * @param string $format The format for the date (e.g., 'M, d').
     * @return self
     */
    public function date(string $format = 'M, d'): self
    {
        $this->isDate = true;
        $this->dateFormat = $format;
        return $this;
    }
}
