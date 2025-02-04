<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="/img/logo-sistema.png">
</head>
<body class="flex items-center justify-center h-screen bg-gradient-to-r from-blue-100 to-blue-300">
    <div class="w-full max-w-md bg-white shadow-xl rounded-lg p-8">
        <div class="flex flex-col items-center mb-6">
            <!-- Imagem centralizada -->
            <img class="mb-4" src="/img/logo-sistema.png" width="80px" alt="Logo">
            <!-- Título centralizado -->
            <h2 class="text-center text-2xl font-extrabold text-gray-800">Bem-vindo(a)</h2>
        </div>
        <!-- Exibição de erros -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <p><strong>Erro:</strong> {{ $errors->first() }}</p>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                    E-mail
                </label>
                <input type="email" name="email" required
                    class="shadow-sm border rounded-lg w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="password">
                    Senha
                </label>
                <input type="password" name="password" required
                    class="shadow-sm border rounded-lg w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
            </div>

            <!-- Checkbox "Lembrar senha" -->
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center text-gray-700 text-sm">
                    <input type="checkbox" name="remember" class="mr-2 leading-tight">
                    <span>Lembrar senha</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">
                    Esqueci minha senha
                </a>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                    Entrar
                </button>
            </div>
        </form>
    </div>
</body>
</html>
