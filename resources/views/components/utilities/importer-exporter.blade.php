<div class="relative">

    {{-- <form action="{{ route('utilities.generic.export') }}" method="GET" style="margin: 0;">
        <input type="hidden" name="model" value="{{ $model }}">
        <button type="submit"
            style="padding: 8px 12px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Exportar
        </button>
    </form> --}}

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('utilities.generic.import') }}" method="POST" enctype="multipart/form-data"
        style="display: flex; align-items: center; gap: 10px; margin: 0;">
        @csrf
        <input type="hidden" name="model" value="{{ $model }}">
        {{-- <input type="file" name="file" required> --}}
        <flux:button variant="primary" color="zinc">Subir archivos</flux:button>
        <input class="absolute inset-0  cursor-pointer opacity-0" type="file" name="file" id="file" required />
        <flux:button type="submit"
            style="padding: 8px 12px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Importar
        </flux:button>
        <span id="selected-files">
            Sin archivos seleccionados
        </span>
    </form>
</div>

<script>
    const label = document.getElementById('selected-files');
    document.getElementById('file').addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
        // Update a display element with the file name
        console.log('Selected file:', fileName);
        label.textContent = fileName;
    });
</script>

{{-- <div class="flex min-h-screen w-full items-center justify-center p-4">
    <div class="w-full max-w-4xl space-y-4">
        <div
            class="bg-background-light/50 dark:bg-background-dark/50 rounded-lg border border-gray-200/20 p-6 shadow-sm dark:border-gray-700/50">
            <div class="flex flex-col items-start gap-6 sm:flex-row">
                <div class="flex flex-1 flex-col gap-2">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Import and Export Data</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Easily manage your data by importing or
                        exporting it in a compatible format.</p>
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ route('utilities.generic.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="model" value="{{ $model }}">
                        <input type="file" name="file" required>
                        <flux:button type="submit" variant="primary" icon="arrow-up-tray">
                            Importar
                        </flux:button>
                    </form>
                    <button
                        class="bg-primary/20 dark:bg-primary/20 text-primary hover:bg-primary/30 dark:hover:bg-primary/40 flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium">
                        <svg fill="currentColor" height="16" viewBox="0 0 256 256" width="16"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M224,144v64a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V144a8,8,0,0,1,16,0v56H208V144a8,8,0,0,1,16,0Zm-85.66-45.66a8,8,0,0,0,11.32,0l40-40a8,8,0,0,0-11.32-11.32L144,81.37V32a8,8,0,0,0-16,0v49.37L93.66,46.34A8,8,0,0,0,82.34,57.66Z">
                            </path>
                        </svg>
                        <span>Import</span>
                    </button>
                    <button
                        class="bg-primary/20 dark:bg-primary/20 text-primary hover:bg-primary/30 dark:hover:bg-primary/40 flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium">
                        <svg fill="currentColor" height="16" viewBox="0 0 256 256" width="16"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M224,144v64a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V144a8,8,0,0,1,16,0v56H208V144a8,8,0,0,1,16,0Zm-93.66,10.34a8,8,0,0,0,11.32,0l40-40a8,8,0,0,0-11.32-11.32L144,137.37V32a8,8,0,0,0-16,0v105.37l-34.34-34.35a8,8,0,0,0-11.32,11.32Z">
                            </path>
                        </svg>
                        <span>Export</span>
                    </button>
                </div>
            </div>
        </div>
        <div
            class="hover:border-primary/50 hover:bg-primary/10 dark:hover:bg-primary/10 relative flex w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300/50 p-12 text-center transition-colors dark:border-gray-700/60">
            <div class="space-y-2">
                <svg aria-hidden="true" class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none"
                    stroke="currentColor" viewBox="0 0 48 48">
                    <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <p class="text-base font-semibold text-gray-900 dark:text-white">Drag and drop files here</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Or, if you prefer...</p>
            </div>
            <button
                class="bg-primary hover:bg-primary/90 focus-visible:outline-primary mt-4 rounded-lg px-5 py-2.5 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">Browse
                Files</button>
            <input class="absolute inset-0 h-full w-full cursor-pointer opacity-0" type="file" />
        </div>
    </div>
</div> --}}
