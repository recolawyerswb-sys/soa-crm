<div>
    <flux:button wire:click="openModal" variant="primary" color="zinc">
        Importar Clientes
    </flux:button>

    <flux:modal wire:model.self="showModal" max-width="2xl">
        <div class="flex flex-col gap-4 p-6"> <div class="flex flex-col gap-2">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Importar Registros
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Sube un archivo (CSV, XLS, XLSX) para importar registros.
                </p>

                <div class="mt-4">

                    @if (!$file)
                    <div
                        x-data="{
                            dragging: false,
                            uploading: false,
                            progress: 0
                        }"

                        @dragover.prevent="dragging = true"
                        @dragleave.prevent="dragging = false"
                        @drop.prevent="dragging = false;
                                      const file = $event.dataTransfer.files[0];
                                      if (file) {
                                          $wire.upload('file', file)
                                      }"

                        x-on:livewire-upload-start="uploading = true; progress = 0"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                        x-on:livewire-upload-finish="uploading = false; progress = 100"
                        x-on:livewire-upload-error="uploading = false; progress = 0"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"

                        :class="{
                            'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/10': dragging,
                            'border-gray-300 dark:border-gray-700': !dragging
                        }"
                        class="relative flex flex-col items-center justify-center w-full p-6 border-2 border-dashed rounded-lg transition-colors duration-200"
                    >
                        <div x-show="uploading"
                             x-transition
                             class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-white/70 dark:bg-gray-900/70 rounded-lg p-6">

                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                  x-text="'Subiendo... ' + progress + '%'">
                                Subiendo... 0%
                            </span>

                            <div class="w-full h-2 mt-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-2 bg-primary-600 rounded-full transition-all duration-300"
                                     :style="{ width: progress + '%' }">
                                </div>
                            </div>
                        </div>

                        <div class="text-center" x-show="!uploading" x-transition>
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium text-primary-600 dark:text-primary-400">Arrastra y suelta</span> tu archivo aquí.
                            </p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">CSV, XLS, XLSX hasta 10MB</p>
                            <div class="mt-4">
                                <input type="file" wire:model="file" id="file-upload-{{ $this->getId() }}" class="hidden" x-ref="fileInput">
                                <flux:button variant="outline" @click="$refs.fileInput.click()">
                                    O selecciona un archivo
                                </flux:button>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if ($file)
                    <div
                        wire:loading.remove wire:target="file"
                        class="flex items-center justify-between w-full p-4 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800"
                    >
                        <div class="flex items-center gap-3 truncate">
                            <svg class="h-6 w-6 text-green-500 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                {{ $file->getClientOriginalName() }}
                            </span>
                        </div>
                        <flux:button variant="primary" color="danger" wire:click="cancelUpload" title="Cancelar subida">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </flux:button>
                    </div>
                    @endif

                    @error('file')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                <flux:button variant="primary" color="zinc" wire:click="closeModal">
                    Cerrar
                </flux:button>
                <flux:button
                    wire:click="import"

                    :disabled="!$file"

                    wire:loading.attr="disabled"
                    wire:target="import, file"
                >
                    <span wire:loading.remove wire:target="import">
                        Importar
                    </span>
                    <span wire:loading wire:target="import" class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Importando...
                    </span>
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
