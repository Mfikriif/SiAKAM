<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Mahasiswa</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-r from-fuchsia-800 from-1% to bg-pink-500 ">
    <nav class="bg-black">
        <div class=" text-white flex justify-between h-14 items-center text-sm w-2/3 mx-auto">
            <div class="flex">
                <img class="w-8 h-9 mr-2" src="{{ asset('undipLogo.png') }}" alt="">
                <h3 class="mt-1.5">SiAKAM Undip</h3>
            </div>
            <div class="flex">
                <h3 class="mt-1.5">Muhammad Daffa Haryono Adiyanto</h3>
                <img class="w-9 h-9 rounded-full ml-3" src="{{ asset('profileMhs.png') }}" alt="">
            </div>
        </div>
    </nav>
    <section>
        <div class=" w-2/3 mx-auto">
            <div class="text-white flex justify-between mt-10 text-sm">
                <p class="">Dasbor</p>
                <p class="">Home / Dasbor</p>
            </div>
            <h1 class="text-white w-2/4 h-20 text-4xl text-start mt-16">Selamat Datang, Muhammad Daffa Haryono Adiyanto!
            </h1>
            <div class="bg-white rounded-lg mt-16">
                <div class="p-7">
                    <p class="ml-4 font-semibold text-gray-700">Profil Mahasiswa</p>
                    <div class="flex ">
                        <div class="flex w-2/4">
                            <img class="rounded-full ml-2 mt-5 w-36 h-36" src="{{ asset('profileMhs.png') }}"
                                alt="">
                            <div class="ml-6 text-base text-gray-500 mt-6 tracking-wide">
                                <p>Muhammad Daffa Haryono Adiyanto <br>
                                    24060122130500 <br>
                                    myonoadi@students.undip.ac.id <br>
                                    myonoadi@gmail.com <br>
                                    087877654321
                                </p>

                                <br>
                                <p>Fakultas Sains Dan Matematika <span class="font-bold">(FSM)</span></p>
                                <p>Departemen Ilmu Komputer/Informatika</p>
                                <p>S1 Informatika</p>
                            </div>
                        </div>


                        <div class=" mx-auto mt-6 w-2/4">
                            <div class="w-32 mx-auto text-base">
                                <div class="flex text-gray-500 w-44 items-center">
                                    <img class="w-5 h-4" src="{{ asset('trophy.svg') }}" alt="">
                                    <h1 class="ml-1">Prestasi Akademik</h1>
                                </div>
                                <div class=" flex justify-between ml-1 mt-4 text-gray-500">
                                    <div>
                                        <p>IPk</p>
                                        <p>4.0</p>
                                    </div>
                                    <div class="w-px h-12 border-solid border border-slate-400"></div>
                                    <div>
                                        <p>SKSk</p>
                                        <p class="ml-1">87</p>
                                    </div>
                                </div>
                            </div>

                            <div class="h-px w-full border-solid border-slate-400 border mt-3 mx-auto"></div>

                            <div class="w-96 mx-auto">
                                <div class="text-center text-xs font-light mt-2">
                                    <p class=""><span class="font-semibold text-gray-500 text-xs">Dosen wali:
                                        </span>Dr.Eng. Adi Wibowo, S.Si,. M.Kom </p>
                                    <p class=""><span class="font-semibold text-gray-500 text-xs">NIP:
                                        </span>198203092006041002</p>
                                </div>

                                <div class="flex justify-between mt-4">
                                    <div class="text-xs text-gray-500">
                                        <p>Semester Akademik</p>
                                        <p class="mt-2">2024/2025 Gasal</p>
                                    </div>
                                    <div class="w-px h-9 border-solid border-slate-400 border"></div>
                                    <div class="text-xs text-gray-500">
                                        <p>Semester Studi</p>
                                        <p class="mt-2 ml-9">5</p>
                                    </div>
                                    <div class="w-px h-9 border-solid border-slate-400 border"></div>
                                    <div class="text-xs text-gray-500">
                                        <p>Status Akademik</p>
                                        <p class="mt-2 bg-green-600 w-9 text-center text-white rounded-sm mx-auto">AKTIF
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-2/3 mx-auto mt-7 grid grid-cols-4 text-lg">
            <div class="flex h-20 w-48 border text-white items-center rounded-md justify-center">
                <img class="w-11 mr-2" src="{{ asset('logoMHS.svg') }}" alt="">
                <p>Her-Registrasi</p>
            </div>
            <div class="flex h-20 w-48 border text-white items-center rounded-md justify-center">
                <img class="h-11 w-11 pl-2" src="{{ asset('irsLogo.svg') }}" alt="">
                <p class="ml-2">IRS Mahasiswa</p>
            </div>
            <div class="flex h-20 w-48 border text-white items-center rounded-md justify-center">
                <img class="w-11 pl-2" src="{{ asset('khsLogo.svg') }}" alt="">
                <p class="ml-2">KHS Mahasiswa</p>
            </div>
            <div class="flex h-20 w-48 border text-white items-center rounded-md justify-center">
                <img class="w-11 pl-2" src="{{ asset('calendarLogo.svg') }}" alt="">
                <p class="ml-2">Jadwal Kuliah</p>
            </div>
        </div>
    </section>

    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-20">
        <div class="flex w-2/3 h-9 mx-auto justify-between items-center text-white ">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>
</body>

</html>
