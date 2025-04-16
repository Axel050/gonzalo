<!DOCTYPE html>
<html>

<head>
    <title>Rol Desactivado</title>
    @vite(['resources/css/app.css']) <!-- Asegúrate de incluir tus estilos -->
</head>

<body class="bg-gray-950">
    <x-placeholder-pattern class="absolute inset-0 size-full stroke-cyan-900/70 " />
    <div class="min-h-screen flex items-center justify-center z-30">
        <div class="bg-linear-to-r from-cyan-800 to-cyan-950 p-8 rounded-lg shadow-md max-w-md w-full text-center z-30">
            <div class="text-red-500 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-200 mb-4">Rol Desactivado</h1>
            <p class="text-gray-300 mb-6">Tu cuenta no tiene permisos activos. Por favor, contacta al administrador.</p>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 cursor-pointer">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</body>

</html>
