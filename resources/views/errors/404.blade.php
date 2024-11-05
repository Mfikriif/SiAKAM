<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <title>404 Not Found</title>
</head>

<body class="flex flex-col min-h-screen bg-indigo-900 relative overflow-hidden h-screen">
    <img src="https://external-preview.redd.it/4MddL-315mp40uH18BgGL2-5b6NIPHcDMBSWuN11ynM.jpg?width=960&crop=smart&auto=webp&s=b98d54a43b3dac555df398588a2c791e0f3076d9"
            class="absolute h-full w-full object-cover" />
    <div class="inset-0 bg-black opacity-25 absolute"></div>

    <main class="container mx-auto px-6 md:px-12 relative z-10 flex items-center justify-center py-32 xl:py-40">
        <div class="w-full font-mono flex flex-col items-center text-center relative z-10">
            <h1 class="font-extrabold text-5xl text-white leading-tight mt-4">
                You are all alone here
            </h1>
            <p class="font-extrabold text-8xl my-44 text-white animate-bounce ml-60">
                404
            </p>

            @if(Auth::check())
                <p class="text-xl text-white font-thin mt-4">
                    Anda akan dialihkan secara otomatis ke beranda dalam beberapa detik...
                </p>

                @php
                    // Ambil pengguna dan peran mereka
                    $user = Auth::user();
                    $roles = [];
                    if ($user->role === 1) {
                        $roles[] = 'mahasiswa';
                    }
                    if ($user->role === 2) {
                        $roles[] = 'akademik';
                    }
                    if ($user->role === 3) {
                        $roles[] = 'dosenwali';
                    }
                    if ($user->role === 4) {
                        $roles[] = 'kaprodi';
                    }
                    if ($user->role === 5) {
                        $roles[] = 'dekan';
                    }
                    if ($user->role === 6) {
                        $roles[] = 'dekan';
                        $roles[] = 'dosenwali';
                    }
                    if ($user->role === 7) {
                        $roles[] = 'kaprodi';
                        $roles[] = 'dosenwali';
                    }

                    // Periksa apakah pengguna memiliki lebih dari satu peran
                    if (count($roles) > 1) {
                        $dashboardUrl = 'select-role';
                    } else {
                        // Dapatkan URL dashboard berdasarkan peran pertama
                        $dashboardUrl = 'mahasiswa/dashboard';
                        if (in_array('dekan', $roles)) {
                            $dashboardUrl = 'dekan/dashboard';
                        } elseif (in_array('dosenwali', $roles)) {
                            $dashboardUrl = 'dosenwali/dashboard';
                        } elseif (in_array('akademik', $roles)) {
                            $dashboardUrl = 'akademik/dashboard';
                        } elseif (in_array('kaprodi', $roles)) {
                            $dashboardUrl = 'kaprodi/dashboard';
                        }
                    }
                @endphp

                <script>
                    setTimeout(function() {
                        window.location.href = "{{ url($dashboardUrl) }}";
                    }, 5000);
                </script>
            @else
                <p class="text-base text-white font-thin mt-4">
                    Anda akan dialihkan secara otomatis ke halaman utama dalam beberapa detik...
                </p>
                <script>
                    setTimeout(function() {
                        window.location.href = "{{ url('/') }}";
                    }, 5000);
                </script>
            @endif
        </div>
    </main>
</body>

</html>