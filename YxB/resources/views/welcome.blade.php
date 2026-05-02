<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YOUxBUILD') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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

        <script type="text/javascript" src="https://static.sketchfab.com/api/sketchfab-viewer-1.12.1.js"></script>
</head>
<body class="bg-premium-black text-white antialiased font-sans flex flex-col min-h-screen selection:bg-premium-gold selection:text-black relative overflow-x-hidden">

        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-premium-gold/5 blur-[120px]"></div>
        <div class="absolute top-[40%] -right-[10%] w-[40%] h-[40%] rounded-full bg-premium-silver/5 blur-[100px]"></div>
    </div>

    @include('layouts.navigation')

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full relative z-10">
        
                <header class="mb-32 pt-10 flex flex-col lg:flex-row items-center justify-between gap-12 sm:gap-20 relative">
            
                        <div class="lg:w-1/2 flex flex-col items-start text-left relative z-20">
                <span class="inline-block px-4 py-1.5 rounded-full border border-premium-gold/30 bg-premium-gold/10 text-premium-goldLight text-xs font-semibold tracking-widest uppercase mb-6 backdrop-blur-sm">
                    Next-Gen Hardware
                </span>
                <h1 class="text-5xl sm:text-6xl md:text-7xl font-heading font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-premium-silver to-white tracking-tight mb-6 leading-tight">
                    Precision<br>Components.
                </h1>
                <p class="text-premium-gray font-medium text-lg md:text-xl leading-relaxed mb-10 max-w-lg">
                    Elevate your rig with hardware designed for absolute performance. Experience the peak of architectural computing from verified vendors in stunning 3D.
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('products.index') }}" class="px-8 py-4 rounded-full bg-gradient-to-r from-premium-gold to-yellow-600 text-premium-black font-heading font-bold text-sm uppercase tracking-widest hover:scale-105 transition-transform duration-300 shadow-glow-gold">
                        Enter Marketplace
                    </a>

                    @guest
                        <a href="{{ route('register') }}" class="px-8 py-4 rounded-full bg-white/5 border border-white/10 text-white font-heading font-bold text-sm uppercase tracking-widest hover:bg-white/10 hover:border-premium-silver transition-all duration-300">
                            Create Account
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="px-8 py-4 rounded-full bg-white/5 border border-white/10 text-white font-heading font-bold text-sm uppercase tracking-widest hover:bg-white/10 hover:border-premium-silver transition-all duration-300">
                            Dashboard Access
                        </a>
                    @endguest
                </div>
            </div>

                        <div class="lg:w-1/2 w-full aspect-square relative z-10 group">
                <div class="absolute inset-0 bg-premium-gold/10 blur-[80px] rounded-full group-hover:bg-premium-gold/20 transition-colors duration-700"></div>
                
                <div class="w-full h-full relative rounded-3xl overflow-hidden border border-white/10 bg-premium-black/50 backdrop-blur-md shadow-glow-subtle group-hover:shadow-glow-gold group-hover:-translate-y-2 group-hover:border-premium-gold/30 transition-all duration-700">
                    
                                        <iframe class="w-full h-full opacity-100 scale-[1.15]" 
                            title="Custom Gaming PC" 
                            frameborder="0" 
                            allowfullscreen 
                            mozallowfullscreen="true" 
                            webkitallowfullscreen="true" 
                            allow="autoplay; fullscreen; xr-spatial-tracking" 
                            xr-spatial-tracking 
                            execution-while-out-of-viewport 
                            execution-while-not-rendered 
                            web-share 
                            src="https://sketchfab.com/models/1a24273417534f69afa0f7c62b643ffc/embed?autospin=1&autostart=1&transparent=1&ui_hint=0&ui_theme=dark&ui_infos=0&ui_watermark=0">
                    </iframe>
                </div>
            </div>

        </header>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20 relative z-20">
            
            <div class="bg-premium-card/60 backdrop-blur-xl rounded-3xl border border-white/5 p-8 transition-transform hover:-translate-y-2 hover:shadow-glow-subtle hover:border-premium-silver/30 duration-300">
                <div class="w-12 h-12 rounded-xl bg-premium-silver/10 text-premium-silver flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-xl font-heading font-bold text-white mb-3">Expansive Catalog</h3>
                <p class="text-premium-gray font-sans leading-relaxed">
                    Filter through hundreds of processors, graphics cards, and high-end motherboards to piece together the ultimate rig.
                </p>
            </div>

            <div class="bg-premium-card/60 backdrop-blur-xl rounded-3xl border border-white/5 p-8 transition-transform hover:-translate-y-2 hover:shadow-glow-gold hover:border-premium-gold/30 duration-300">
                <div class="w-12 h-12 rounded-xl bg-premium-gold/10 text-premium-gold flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-xl font-heading font-bold text-transparent bg-clip-text bg-gradient-to-r from-premium-gold to-yellow-500 mb-3">Secure Transactions</h3>
                <p class="text-premium-gray font-sans leading-relaxed">
                    Account-based procurement ensures your cart is protected, tracked, and directly connected with our verified vendors.
                </p>
            </div>

            <div class="bg-premium-card/60 backdrop-blur-xl rounded-3xl border border-white/5 p-8 transition-transform hover:-translate-y-2 hover:shadow-glow-subtle hover:border-premium-silver/30 duration-300">
                <div class="w-12 h-12 rounded-xl bg-premium-silver/10 text-premium-silver flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-xl font-heading font-bold text-white mb-3">Vendor Operations</h3>
                <p class="text-premium-gray font-sans leading-relaxed">
                    Set up shop. Manage your inventory availability, update pricing in real-time, and process incoming client orders seamlessly.
                </p>
            </div>
            
        </div>
    </main>

    <footer class="border-t border-white/10 text-center py-8 relative z-10 bg-premium-black/50 backdrop-blur-md">
        <p class="text-premium-gray font-sans text-sm">&copy; 2026 YOUXBUILD. Performance through Architecture.</p>
    </footer>
</body>
</html>
