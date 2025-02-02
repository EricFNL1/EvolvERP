<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon"  href="/img/logo-sistema.png">
</head>
<body class="d-flex">
    <!-- Barra de navegação -->
    <nav class="bg text-white d-flex flex-column justify-content-between" style="width: 250px; min-height: 100vh;">
    <!-- Conteúdo superior -->
    <div>
        <div class="text-center mb-4 mt-4">
            <!-- Logo centralizado -->
            <div class="d-flex justify-content-center align-items-center">
                <img src="/img/logo-sistema.png" width="80px" alt="Logo">
            </div>
            <h2 class="titulo mt-2 text-center">EvolvERP</h2>
        </div>
        <p class="text-uppercase text-secondary text-center">Menu Principal</p>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="#" class="nav-link text-white"><i class="bi bi-shield-lock"></i> Segurança</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white"><i class="bi bi-browser-chrome"></i> Website</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white"><i class="bi bi-envelope"></i> Comunicação</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white"><i class="bi bi-people"></i> Cadastros Gerais</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white"><i class="bi bi-book"></i> Módulos de Convivência</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white"><i class="bi bi-pencil"></i> Assinatura Digital</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white"><i class="bi bi-currency-dollar"></i> Módulo Financeiro</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white"><i class="bi bi-star"></i> Outro Módulo</a>
            </li>
        </ul>
    </div>

    <!-- Guia inferior -->
    <div class="fixed-bottom d-flex justify-content-around align-items-center py-3" 
    style="border-top: 1px solid rgba(255, 255, 255, 0.2); background-color: #2B3E50; width: 250px;">
        <a href="#" class="text-white"><i class="bi bi-house-door-fill"></i></a>
        <a href="#" class="text-white"><i class="bi bi-arrows-fullscreen"></i></a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded"><a href="#" class="text-white"><i class="bi bi-power"></i></a></button>
        </form>
        
    </div>
</nav>

    <!-- Conteúdo principal -->
    <main class="flex-grow bg-gray-100 p-4">
        <h1 class="text-2xl font-bold">Bem-vindo ao ERP</h1>
        <p class="mt-2">Este é seu painel inicial.</p>

        <!-- Botão de Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">Logout</button>
        </form>
    </main>
</body>
</html>
