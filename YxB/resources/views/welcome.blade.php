<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'YOUxBUILD') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900">
        @include('layouts.navigation')

        <main>
            <section class="bg-white border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div class="max-w-3xl space-y-6">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">
                            Welcome to YOUxBUILD
                        </p>

                        <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-gray-900">
                            PC marketplace home page here.
                        </h1>

                        

                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('products.index') }}" class="px-5 py-3 bg-gray-900 text-white rounded-md">
                                Browse Products
                            </a>

                            @guest
                                <a href="{{ route('register') }}" class="px-5 py-3 bg-white border border-gray-300 rounded-md">
                                    Create Account
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="px-5 py-3 bg-white border border-gray-300 rounded-md">
                                    Go to Dashboard
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-6 md:grid-cols-3">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold mb-3">Public Browsing</h2>
                            <p class="text-gray-600">
                                Visitors can explore the marketplace and discover products before signing in.
                            </p>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold mb-3">Account Required</h2>
                            <p class="text-gray-600">
                                Product details and ordering are protected so users authenticate before purchasing.
                            </p>
                        </div>
                        <div class="sketchfab-embed-wrapper"> <iframe title="CUSTOM GAMING PC (FBX file)" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share width="640" height="480" src="https://sketchfab.com/models/00bb790319c045058290dfbb4873f3ac/embed?autospin=1&autostart=1&transparent=1&dnt=1"> </iframe> <p style="font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;"> <a href="https://sketchfab.com/3d-models/custom-gaming-pc-fbx-file-00bb790319c045058290dfbb4873f3ac?utm_medium=embed&utm_campaign=share-popup&utm_content=00bb790319c045058290dfbb4873f3ac" target="_blank" rel="nofollow" style="font-weight: bold; color: #1CAAD9;"> CUSTOM GAMING PC (FBX file) </a> by <a href="https://sketchfab.com/Yolala3d?utm_medium=embed&utm_campaign=share-popup&utm_content=00bb790319c045058290dfbb4873f3ac" target="_blank" rel="nofollow" style="font-weight: bold; color: #1CAAD9;"> Yolala3D | Y3D </a> on <a href="https://sketchfab.com?utm_medium=embed&utm_campaign=share-popup&utm_content=00bb790319c045058290dfbb4873f3ac" target="_blank" rel="nofollow" style="font-weight: bold; color: #1CAAD9;">Sketchfab</a></p></div>

                        
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
