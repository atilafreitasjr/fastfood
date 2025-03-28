<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Garage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased h-screen w-screen">

    {{-- The main content with `full-width` --}}
    <x-mary-main with-nav full-width class="h-full">

        {{-- This is a sidebar that works also as a drawer on small screens --}}
        {{-- Notice the `main-drawer` reference here --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200 h-full">

            {{-- Brand --}}
            <div class="flex justify-center items-center p-4">
                <img src="{{ asset('imagens/logo_Park_Garage.svg') }}" alt="Garage Park" class="h-32">
            </div>

            {{-- User --}}
            @if($user = auth()->user())
                <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="pt-2">
                    <x-slot:actions>
                        <x-mary-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate link="/logout" />
                    </x-slot:actions>
                </x-mary-list-item>

                <x-mary-menu-separator />
            @endif

            {{-- Activates the menu item when a route matches the `link` property --}}
            <x-mary-menu activate-by-route>
                <x-mary-menu-item title="Estacionados" icon="o-truck" link="/parking" class="text-lg" icon-class="text-2xl" />
                <x-mary-menu-item title="Entrada" icon="o-arrow-small-down" link="{{ route('entrada.veiculo') }}" class="text-lg" icon-class="text-2xl" />
                <x-mary-menu-item title="Saída" icon="o-arrow-small-up" link="{{ route('saida.veiculo') }}" class="text-lg" icon-class="text-2xl" />
                <x-mary-menu-item title="Relatórios" icon="o-document" link="{{ route('relatorio.veiculo') }}" class="text-lg" icon-class="text-2xl" />
                <x-mary-menu-item title="Mensagem" icon="o-envelope" link="{{ route('mensagens') }}" class="text-lg" icon-class="text-2xl" />
                <x-mary-menu-item title="Notificações" icon="o-bell" link="{{ route('notificacoes') }}" class="text-lg" icon-class="text-2xl" />
                <x-mary-menu-separator />
                <x-mary-menu-sub title="Configurações" icon="o-cog-6-tooth" class="text-lg" icon-class="text-2xl">
                    <x-mary-menu-item title="Wifi" icon="o-wifi" link="####" class="text-lg" icon-class="text-2xl" />
                    <x-mary-menu-item title="Archives" icon="o-archive-box" link="####" class="text-lg" icon-class="text-2xl" />
                </x-mary-menu-sub>
            </x-mary-menu>
        </x-slot:sidebar>

        {{-- footer --}}
        <x-slot:footer class="bg-base-200 p-4 text-center text-sm">
            <div class="text-sm">
                &copy; {{ date('Y') }} Parking Garage. All rights reserved. - Desenvolvimento &copy;ATITEC - Tecnologia: Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
            <div class="ml-auto">
                {{-- <button class="fullscreen-button btn btn-primary" onclick="toggleFullscreen()">Fullscreen</button> --}}
            </div>
        </x-slot:footer>

        {{-- The `$slot` goes here --}}
        <x-slot:content class="h-full bg-logo">
            {{ $slot }}
            @yield('content')
        </x-slot:content>

        {{--  TOAST area --}}
        <x-mary-toast />

    </x-mary-main>

    @livewireScripts

</body>
</html>
