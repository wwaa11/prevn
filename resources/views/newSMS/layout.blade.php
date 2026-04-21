<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Praram9 CheckUP')</title>

    <script src="{{ asset("js/axios.min.js") }}"></script>
    <script src="{{ asset("js/sweetalert2.js") }}"></script>
    <script src="{{ asset("js/jquery.min.js") }}"></script>
    <link rel="stylesheet" href="{{ asset("font-awesome/css/all.min.css") }}">
    <link rel="icon" href="{{ asset("images/Logo.ico") }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(["resources/css/app.css", "resources/js/app.js"])

    <style>
        :root {
            --p9-primary: #37beaf;
            --p9-gradient: linear-gradient(135deg, #37beaf 0%, #0ba2ab 100%);
        }
        body {
            font-family: 'Prompt', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }
        .gradient-card {
            background: var(--p9-gradient);
            border-radius: 24px;
            position: relative;
            overflow: hidden;
        }
        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
        }
    </style>
</head>
<body class="antialiased text-slate-800 flex flex-col min-h-screen">

    <nav class="flex items-center justify-between p-4 md:px-8 bg-white/50 backdrop-blur-md sticky top-0 z-50">
        <div class="w-12"></div> <img width="70" src="{{ asset("images/logo.png") }}" alt="Praram 9 Logo" class="hover:opacity-80 transition-opacity">

        <div class="relative">
            <select id="langSelecter" onchange="langSelect()" 
                class="custom-select block text-sm font-medium bg-white border border-slate-200 text-slate-600 py-1.5 pl-3 pr-8 rounded-full focus:ring-2 focus:ring-teal-500 transition-all cursor-pointer shadow-sm">
                <option value="TH" @if (session("langSelect") == "TH") selected @endif>TH</option>
                <option value="ENG" @if (session("langSelect") == "ENG") selected @endif>ENG</option>
            </select>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="p-8 text-center text-slate-400 text-xs">
        <p>&copy; {{ date('Y') }} Praram 9 Hospital. Premium Digital Experience.</p>
    </footer>

    <script>
        function langSelect() {
            const lang = $('#langSelecter').val();
            const formData = new FormData();
            formData.append('lang', lang);
            
            Swal.fire({
                title: 'Updating Language...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading() }
            });

            axios.post("{{ env("APP_URL") }}/changeLang", formData, {
                "Content-Type": "multipart/form-data"
            }).then(() => {
                window.location.reload();
            }).catch(() => {
                Swal.fire('Error', 'Unable to change language.', 'error');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>