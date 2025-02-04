<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gradient-to-r from-blue-100 to-blue-300">
    <div class="w-full max-w-md bg-white shadow-xl rounded-lg p-8">
        <!-- Título centralizado -->
        <h2 class="text-center text-2xl font-extrabold text-gray-800 mb-6">Esqueci minha senha</h2>
        
        <!-- Mensagens de Sucesso ou Erro -->
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <p><strong>Erro:</strong> {{ $errors->first() }}</p>
            </div>
        @endif

        <!-- Formulário -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                    E-mail
                </label>
                <input type="email" name="email" required
                    class="shadow-sm border rounded-lg w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                    Enviar link de redefinição
                </button>
            </div>
        </form>

        <!-- Botão de Voltar -->
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                Voltar
            </a>
        </div>
    </div>
</body>
</html>
