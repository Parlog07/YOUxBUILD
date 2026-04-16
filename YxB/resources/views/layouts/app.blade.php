<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts (Temporary CDN for Vite/Node18 issue) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            premium: {
                                black: '#0A0A0A',
                                dark: '#141414',
                                card: '#1C1C1E',
                                gold: '#D4AF37',
                                goldLight: '#F3E5AB',
                                silver: '#C0C0C0',
                                gray: '#8E8E93',
                            }
                        },
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            heading: ['Montserrat', 'sans-serif'],
                        },
                        boxShadow: {
                            'glow-gold': '0 0 20px -5px rgba(212, 175, 55, 0.3)',
                            'glow-subtle': '0 10px 30px -10px rgba(0, 0, 0, 0.8)',
                        }
                    }
                }
            }
        </script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    </head>
    <body class="bg-premium-black text-white antialiased font-sans flex flex-col min-h-screen selection:bg-premium-gold selection:text-black">
        <div class="min-h-screen flex flex-col bg-premium-black relative">
            <!-- Ambient Glow Background Effects -->
            <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
                <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-premium-gold/5 blur-[120px]"></div>
                <div class="absolute top-[40%] -right-[10%] w-[40%] h-[40%] rounded-full bg-premium-silver/5 blur-[100px]"></div>
            </div>
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
