<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>dashboard Kaprodi</title>
    @vite('resources/css/app.css')

</head>

<body class="bg-gradient-to-r from-fuchsia-800 from-1% to bg-pink-500 ">
    <nav class="bg-black">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white">Logout</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <div class=" text-white flex justify-between h-14 items-center text-sm w-2/3 mx-auto">
            <div class="flex">
                <img class="w-8 h-9 mr-2" src="{{ asset('undipLogo.png') }}" alt="">
                <h3 class="mt-1.5">SiAKAM Undip</h3>
            </div>
            <div class="flex">
                <img class="w-4 h-4 text-center my-auto mr-3" src="{{ asset('notif-logo.png') }}" alt="">
                <h3 class="mt-1.5">Muhammad Ajisadda Firdaus</h3>
                <img class="w-9 h-9 rounded-full ml-3" src="{{ asset('profilPembimbing.png') }}" alt="">
            </div>
        </div>
    </nav>
    <section>
        <div class=" w-2/3 mx-auto">
            <div class="text-white flex justify-between mt-10 text-sm">
                <p class="">Dasbor</p>
                <p class="">Home / Dasbor</p>
            </div>
            <h1 class="text-white w-80 text-4xl text-start mt-16">Selamat
                Datang,
            </h1>
            <h1 class="text-white w-101 h-20 text-4xl text-start"> Muhammad Ajisadda Firdaus!</h1>
            <div class="bg-white rounded-lg mt-10">
                <div class="p-7">
                    <div class="flex justify-between h-72">
                        <div class="flex w-2/4">
                            <div class=" w-72">
                                <p class="  font-semibold text-gray-700 w-full">Profil
                                    Ketua Program Studi
                                </p>

                                <img class="rounded-full ml-2 mt-5 w-36 h-36" src="{{ asset('profilPembimbing.png') }}"
                                    alt="">
                            </div>
                            <div class="text-base text-gray-500 mt-6 tracking-wide w-96">
                                <p>Muhammad Ajisadda Firdaus <br>
                                    199603032024061003 <br>
                                    msaddafirdaus@kaprodi.undip.ac.id <br>
                                    msaddafirdaus@gmail.com <br>
                                    085872251414
                                </p>

                                <br>
                                <p>Fakultas Sains Dan Matematika <span class="font-bold">(FSM)</span></p>
                                <p>Departemen Ilmu Komputer/Informatika</p>
                                <p>S1 Informatika</p>
                            </div>
                        </div>

                        <div class="border border-slate-300"></div>

                        <div class=" w-2/4">
                            <div class="pt-4 flex flex-wrap justify-center items-center gap-7 mt-5">
                                <div class="border border-gray-500 w-36 h-20 flex flex-col items-center rounded-xl">
                                    <p class="pt-2 text-xs text-gray-500">Total Mahasiswa</p>
                                    <p class="pt-2 font-semibold text-lg">1340</p>
                                </div>
                                <div class="border border-gray-500 w-36 h-20 flex flex-col items-center rounded-xl">
                                    <p class="pt-2 text-xs text-gray-500">Total Dosen</p>
                                    <p class="pt-2 font-semibold text-lg">258</p>
                                </div>
                                <div class="border border-gray-500 w-36 h-20 flex flex-col items-center rounded-xl">
                                    <p class="pt-2 text-xs text-gray-500">Retata IPK</p>
                                    <p class="pt-2 font-semibold text-lg">3.23</p>
                                </div>
                                <div class="border border-gray-500 w-36 h-20 flex flex-col items-center rounded-xl">
                                    <p class="pt-2 text-xs text-gray-500">Belum Bayar UKT</p>
                                    <p class="pt-2 font-semibold text-lg">234</p>
                                </div>
                                <div class="border border-gray-500 w-36 h-20 flex flex-col items-center rounded-xl">
                                    <p class="pt-2 text-xs text-gray-500">Belum mengisi IRS</p>
                                    <p class="pt-2 font-semibold text-lg">120</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-2/3 mx-auto mt-7 grid grid-cols-4 text-lg">
            <button class="flex h-20 border text-white items-center rounded-md ">
                <img class="w-11 mr-2 ml-4" src="{{ asset('calendarLogo.svg') }}" alt="">
                <p class="mx-auto w-36">Pengajuan Jadwal Kuliah</p>
            </button>
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
