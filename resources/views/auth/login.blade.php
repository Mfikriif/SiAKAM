<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    @vite('resources/css/app.css')
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

                <div class="flex items-center border rounded-lg p-2 mt-5">
                    <img src="{{ asset('account.png') }}" alt="">
                    <input type="text" name="email" placeholder="Email"
                        class="flex-1 border-none bg-transparent pl-4" required autofocus>
                </div>
                @error('email')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror

                <div class="flex items-center border rounded-lg p-2 mt-3">
                    <img src="{{ asset('lock-outline.png') }}" alt="">
                    <input type="password" name="password" placeholder="Password"
                        class="flex-1 border-none bg-transparent pl-4" required>
                </div>
                @error('password')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror

                <button type="submit"
                    class="border-solid border-2 border-blue-700 w-full h-12 mt-3 rounded-md text-white bg-blue-600">
                    LOGIN
                </button>
            </form>
        </div>
    </div>
</body>

</html>
