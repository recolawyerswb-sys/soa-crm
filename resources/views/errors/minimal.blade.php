<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

       <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&amp;display=swap"
            rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
        <script>
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            primary: "#137fec",
                            "background-light": "#f6f7f8",
                            "background-dark": "#101922",
                        },
                        fontFamily: {
                            display: ["Manrope", "sans-serif"],
                        },
                        borderRadius: {
                            DEFAULT: "0.25rem",
                            lg: "0.5rem",
                            xl: "0.75rem",
                            full: "9999px"
                        },
                    },
                },
            };
        </script>
    </head>
    <body class="antialiased bg-background-light dark:bg-background-dark font-display">
        <div class="group/design-root relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden">
            <div class="layout-container flex h-full grow flex-col">
                <div class="flex flex-1 justify-center px-4 py-5 md:px-40">
                    <div class="layout-content-container flex max-w-[960px] flex-1 flex-col">
                        <div class="flex flex-1 flex-col items-center justify-center px-4 py-6">
                            <div class="flex flex-col items-center gap-8">
                                <div class="aspect-square w-full max-w-[320px] rounded-lg bg-contain bg-center bg-no-repeat"
                                    data-alt="A gift box with slightly torn wrapping paper sitting on a wooden surface."
                                    style='background-image: url("{{ asset('error_pet.jpg') }}");'>
                                </div>
                                <div class="flex max-w-[480px] flex-col items-center gap-4 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <p class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">@yield('error_title')</p>
                                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">@yield('code') - @yield('code_desc')</p>
                                    </div>
                                    <p class="text-base font-normal leading-normal text-slate-600 dark:text-slate-400">
                                        @yield('message')
                                        @hasSection('link')
                                            @yield('link')
                                        @endif
                                    </p>
                                </div>
                                <a
                                    href="/crm"
                                    class="bg-primary hover:bg-primary/90 focus:ring-primary flex h-12 min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg px-6 text-base font-bold text-white shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">
                                    <span class="truncate">Llevame de vuelta a estar seguro</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
