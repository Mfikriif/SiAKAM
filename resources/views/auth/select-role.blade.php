<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Role</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div id="jumbotron" class="relative h-screen w-screen bg-cover bg-center flex justify-center items-center"
        style="background-image: url('{{ asset('Gedung-WP 1.png') }}');">
        
        <!-- Center the form container -->
        <div class="bg-white w-100 mx-auto my-auto rounded-xl shadow-lg p-8">   
            <img class="mx-auto" src="{{ asset('undipLogo.png') }}" alt="">
            <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">Pilih Role Anda</h2>

            <form method="POST" action="{{ route('role.select') }}">
                @csrf
                @foreach ($roles as $role)
                    <button type="submit" name="role" value="{{ $role }}" class="block w-full bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white py-3 my-3 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                        {{ ucfirst($role) }} Dashboard
                    </button>
                @endforeach
            </form>

            <div class="mt-6">
                <p class="text-center text-gray-600">Logged in as: <span class="font-semibold">{{ Auth::user()->name }}</span></p>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg shadow-md w-full transform hover:scale-105 transition-transform duration-300">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>