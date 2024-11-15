<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    <div id="jumbotron" class="relative h-screen w-screen bg-cover bg-center flex"
        style="background-image: url('{{ asset('Gedung-WP 1.png') }}');">
        <div class="bg-white w-100 mx-auto my-auto rounded-xl shadow-lg p-8">
            <div class="text-center">
                <img class="mx-auto" src="{{ asset('undipLogo.png') }}" alt="">
                <h1 class="text-center text-3xl pt-5 tracking-wide">Sistem Informasi Akademik Mahasiswa (SiAKAM)</h1>
                <p class="text-center pt-2 text-slate-500 tracking-wider ">Universitas Diponegoro</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Input for Login (email or NIM) -->
                <div class="flex items-center border rounded-lg p-2 mt-5">
                    <img src="{{ asset('account.png') }}" alt="">
                    <input type="text" name="login" placeholder="Email atau NIM" class="flex-1 border-none bg-transparent pl-4" autofocus>
                </div>
                @error('login')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror

                <!-- Password Input Group with Show/Hide Functionality -->
                <div class="flex items-center border rounded-lg p-2 mt-3 relative">
                    <img src="{{ asset('lock-outline.png') }}" alt="" class="w-5 h-5">
                    <input id="password" type="password" name="password" placeholder="Kata Sandi"
                        class="flex-1 border-none bg-transparent pl-4 focus:outline-none" required>
                    <button type="button" onclick="togglePassword()" class="absolute right-3 text-gray-500 focus:outline-none">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path id="eye-open" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path id="eye-open-path" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            <path id="eye-closed" class="hidden" d="M4.5 19.5l15-15M19.5 19.5l-15-15"></path>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror

                <button type="submit"
                    class="border-solid border-2 border-blue-700 w-full h-12 mt-3 rounded-md text-white bg-blue-600">
                    MASUK
                </button>
            </form>
        </div>
    </div>

    <script>
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eye-icon");
    if (passwordInput && eyeIcon) {
        const eyeOpen = eyeIcon.querySelector("#eye-open");
        const eyeClosed = eyeIcon.querySelector("#eye-closed");

        window.togglePassword = function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeOpen.classList.add("hidden");
                eyeClosed.classList.remove("hidden");
            } else {
                passwordInput.type = "password";
                eyeOpen.classList.remove("hidden");
                eyeClosed.classList.add("hidden");
            }
        };
    }
    </script>
</body>

</html>
