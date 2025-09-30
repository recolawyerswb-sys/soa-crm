<div
    x-data="{
        show: false,
        title: '',
        message: '',
        status: '200',
        {{-- statusColors: {
            '100': 'bg-indigo-500',
            '200': 'bg-green-300',
            '300': 'bg-orange-500',
            '400': 'bg-red-500'
        }, --}}
        statusIcons: {
            '100': 'information-circle',
            '200': 'check-circle',
            '300': 'exclamation-triangle',
            '400': 'exclamation-circle'
        },
        showNotification(event) {
            this.status = event.detail[0].status || '200';
            this.title = event.detail[0].title || 'Operacion exitosa';
            this.message = event.detail[0].message || 'Su mensaje aqui';
            this.show = true;

            setTimeout(() => {
                this.show = false;
            }, 5000); // La notificación se ocultará después de 5 segundos
        }
    }"
    x-on:show-notification.window="showNotification($event)"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    {{-- x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" --}}
    x-transition:leave-start="translate-x-2 opacity-100 sm:translate-x-0 sm:translate-x-2"
    x-transition:leave-end="translate-x-6 opacity-0 sm:translate-y-0"
    class="fixed top-0 right-0 z-50 max-w-sm w-full mt-4 mr-2"
    style="display: flex;"
>
    <div class="rounded w-full shadow-lg overflow-hidden bg-white dark:bg-slate-800">
        {{-- CONTENT ROW --}}
        <div class="flex gap-2 px-3 py-3">
            {{-- ICON COLUMN --}}
            <div class="flex justify-start items-start w-auto pt-1">
                {{-- ACA VA EL NOMBRE DEL ICONO QUE DEBE SER RENDERIZADO AUTOMATICAMENTE --}}
                <template x-if="statusIcons[status] === 'check-circle'">
                    <flux:icon class="size-6 dark:text-green-500" name="check-circle" variant="solid"></flux:icon>
                </template>
                <template x-if="statusIcons[status] === 'exclamation-circle'">
                    <flux:icon name="exclamation-circle" variant="solid"></flux:icon>
                </template>
                <template x-if="statusIcons[status] === 'exclamation-triangle'">
                    <flux:icon name="exclamation-triangle" variant="solid"></flux:icon>
                </template>
                <template x-if="statusIcons[status] === 'information-circle'">
                    <flux:icon name="information-circle" variant="solid"></flux:icon>
                </template>
            </div>
            {{-- DETAILS COLUMN --}}
            <div class="flex flex-col w-full">
                <span class="dark:text-white text-slate-700 font-semibold" x-text="title"></span>
                {{-- DESCRIPTION ROW --}}
                <p class="text-sm dark:text-white text-slate-400" x-text="message"></p>
            </div>
            {{-- ACTIONS COLUMN --}}
            <div class="flex justify-center items-start w-auto">
                <button @click="show = false">
                    <flux:icon class="size-6" name='x-mark'></flux:icon>
                </button>
            </div>
        </div>
    </div>
</div>
