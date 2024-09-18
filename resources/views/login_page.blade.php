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
    <div id="jumbotron" class="relative h-screen w-screen bg-cover bg-center flex "
        style="background-image: url('{{ asset('Gedung-WP 1.png') }}');">
        <div class="bg-white w-100 mx-auto my-auto rounded-xl ">
            <div class="w-99 mx-auto pt-10">
                <img class="mx-auto" src="{{ asset('undipLogo.png') }}" alt="">
                <h1 class="text-center text-3xl pt-5 tracking-wide">Sistem Informasi Akademik Mahasiswa
                    (SiAkam)</h1>
                <p class="text-center pt-2 text-slate-500 tracking-wider ">Universitas Diponegoro</p>
                <div class="flex items-center border rounded-lg p-2 mt-5">
                    <img src="{{ asset('account.png') }}" alt="">
                    <input type="text" placeholder="username/e-mail official SiAKAM"
                        class="flex-1 outline-none bg-transparent pl-4">
                </div>
                <div class="flex items-center border rounded-lg p-2 mt-3">
                    <img src="{{ asset('lock-outline.png') }}" alt="">
                    <input type="text" placeholder="password" class="flex-1 outline-none bg-transparent pl-4">
                </div>
                <button
                    class="border-solid border-2 border-slate-300 w-full h-12 mt-3 rounded-md text-slate-300 hover:border-sky-700 hover:text-sky-700 ">LOGIN
                </button>
                <button class="w-full h-10 mt-6 rounded-md text-white bg-red-500">Reset Password</button>
                <p class="text-slate-400 font-light">Belum memiliki akun?</p>
                <p class="text-red-500 pb-4">Daftar sekarang!</p>
            </div>
        </div>
    </div>


</body>

</html>
