@php
    use App\Helpers\Views\NavItems;
    $navItems = NavItems::getProfileNavigationItems();
@endphp

<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">

        <flux:navlist>
             @foreach ($navItems as $navItem)
                @role($navItem['role'])
                    <flux:navlist.item
                        icon="{{ $navItem['icon'] }}"
                        :href="route($navItem['routeName'])"
                        :current="request()->routeIs($navItem['routeName'])"
                        wire:navigate>
                        {{ __($navItem['label']) }}
                    </flux:navlist.item>
                @endrole
            @endforeach
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <div class="mt-5 w-full max-w-2xl">
            {{ $slot }}
        </div>
    </div>
</div>
