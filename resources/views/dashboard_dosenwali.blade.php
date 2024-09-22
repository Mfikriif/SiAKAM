<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>dashboard dosen</title>
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
                <img class="w-4 h-4 text-center my-auto mr-3" src="{{ asset('notif-logo.png') }}" alt="">
                <h3 class="mt-1.5">Firdaus Ajisadda Adiyanto Adriansyah</h3>
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
            <h1 class="text-white w-101 h-20 text-4xl text-start"> Firdaus Ajisadda Adiyanto
                Adriansyah!</h1>
            <div class="bg-white rounded-lg mt-16">
                <div class="p-7">
                    <div class="flex justify-between h-72">
                        <div class="flex w-2/4">
                            <div class=" w-72">
                                <p class="  font-semibold text-gray-700 w-full">Profil
                                    Pembimbing
                                    Akademik
                                </p>

                                <img class="rounded-full ml-2 mt-5 w-36 h-36" src="{{ asset('profilPembimbing.png') }}"
                                    alt="">
                            </div>
                            <div class="text-base text-gray-500 mt-6 tracking-wide w-96">
                                <p>Firdaus Ajisadda Adiyanto Adriansya <br>
                                    128198217373671631 <br>
                                    akudosen@lecturer.undip.ac.id <br>
                                    akudosen@gmail.com <br>
                                    08818281288121
                                </p>

                                <br>
                                <p>Fakultas Sains Dan Matematika <span class="font-bold">(FSM)</span></p>
                                <p>Departemen Ilmu Komputer/Informatika</p>
                                <p>S1 Informatika</p>
                            </div>
                        </div>

                        <div class="border border-slate-300"></div>

                        <div class=" w-2/4">
                            <p class="ml-4 text-gray-500 tracking-wide ">Jadwal Mendatang</p>
                            <div class="mt-5">
                                <div class="flex ml-5">
                                    <img src="{{ asset('Ellipse1.svg') }}" alt="">
                                    <p class="text-gray-500 tracking-wide ml-3">Pemrograman Berorientasi Objek C</p>
                                    <p class="text-gray-500 ml-4">07.00 s/d 09.30</p>
                                    <p class="text-gray-500 ml-4">E101</p>
                                </div>
                                <div class="flex ml-5">
                                    <img src="{{ asset('Ellipse1.svg') }}" alt="">
                                    <p class="text-gray-500 tracking-wide ml-3">Pemrograman Berorientasi Objek A</p>
                                    <p class="text-gray-500 ml-4">13.00 s/d 15.30</p>
                                    <p class="text-gray-500 ml-4">E101</p>
                                </div>
                                <div class="flex ml-5">
                                    <img src="{{ asset('Ellipse1.svg') }}" alt="">
                                    <p class="text-gray-500 tracking-wide ml-3">Pemrograman Berorientasi Objek B</p>
                                    <p class="text-gray-500 ml-4">15.40 s/d 18.10</p>
                                    <p class="text-gray-500 ml-4">E101</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-2/3 mx-auto mt-7 grid grid-cols-4 text-lg">
            <button class="flex h-20 w-48 border text-white items-center rounded-md justify-center">
                <img class="w-11 mr-2" src="{{ asset('irsLogo.svg') }}" alt="">
                <p>Pengajuan IRS</p>
            </button>
            <button class="flex h-20 w-64 border text-white items-center rounded-md justify-center ">
                <img class="h-11 w-20  " src="{{ asset('logoMHS.svg') }}" alt="">
                <p class=" text-center">Mahasiswa Perwalian</p>
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
