<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeLivewireModalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire-modal {name : El nombre del componente Livewire (ej. Clients/CreateClient)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is an useful command to create a Livewire modal component.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Obtener el nombre del argumento
        $name = $this->argument('name');

        // 2. Llamar al comando make:livewire original
        $this->call('make:livewire', ['name' => $name]);

        // 3. Determinar la ruta de la vista creada por Livewire (LÓGICA CORREGIDA)
        // Convertimos cada segmento de la ruta a kebab-case por separado.
        // Ejemplo: 'Modals/CreateUser' -> ['modals', 'create-user'] -> 'modals/create-user'
        $viewPathSegments = collect(explode('/', $name))
            ->map(fn ($segment) => Str::kebab($segment))
            ->implode('/');

        $viewPath = resource_path('views/livewire/' . $viewPathSegments . '.blade.php');

        if (!File::exists($viewPath)) {
            $this->error("La vista de Livewire no se encontró en: {$viewPath}");
            return self::FAILURE;
        }

        // 4. Preparar el contenido dinámico para el stub
        // Extrae el nombre del modelo, ej. 'CreateUser' -> 'User'
        $modelName = Str::of($name)->afterLast('/')->replace('Create', '')->replace('Edit', '')->singular();
        $title = "Crear " . Str::lower($modelName);
        $description = "Proporciona los detalles del nuevo " . Str::lower($modelName) . ".";

        // Convierte 'Modals/CreateUser' a 'create-user' para el modalName
        $modalName = Str::kebab(Str::of($name)->afterLast('/'));

        // 5. Leer el stub y reemplazar los marcadores de posición
        $stubContent = File::get(base_path('stubs/livewire.modal.stub'));
        $stubContent = str_replace(
            ['{{ title }}', '{{ description }}', '{{ modalName }}'],
            [__($title), __($description), $modalName],
            $stubContent
        );

        // 6. Sobrescribir la vista de Livewire con la nueva plantilla
        File::put($viewPath, $stubContent);

        $this->info("¡Componente modal de Livewire creado exitosamente!");
        $this->comment("Clase: app/Livewire/{$name}.php");
        $this->comment("Vista: " . str_replace(base_path() . '/', '', $viewPath));

        return self::SUCCESS;
    }
}
