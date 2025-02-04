<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EvolvERP - Estoque</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="/img/logo-sistema.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="d-flex">
    <!-- Barra de navegação -->
    <nav class="bg text-white d-flex flex-column justify-content-between" style="width: 250px; min-height: 100vh;">
        <div>
            <div class="text-center mb-4 mt-4">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="/img/logo-sistema.png" width="80px" alt="Logo">
                </div>
                <h2 class="titulo mt-2 text-center">EvolvERP</h2>
            </div>
            <p class="text-uppercase text-secondary text-center">Menu Principal</p>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="/seguranca" class="nav-link text-white"><i class="bi bi-shield-lock"></i> Segurança</a></li>
                <li class="nav-item"><a href="/website" class="nav-link text-white"><i class="bi bi-browser-chrome"></i> Website</a></li>
                <li class="nav-item"><a href="/estoque" class="nav-link text-white active"><i class="bi bi-box"></i> Estoque</a></li>
            </ul>
        </div>

         <!-- Guia inferior -->
    <div class="fixed-bottom d-flex justify-content-around align-items-center py-3" 
    style="border-top: 1px solid rgba(255, 255, 255, 0.2); background-color: #2B3E50; width: 250px;">
        <a href="{{ route('dashboard') }}" class="text-white"><i class="bi bi-house-door-fill"></i></a>
        <a href="#" class="text-white"><i class="bi bi-arrows-fullscreen"></i></a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded"><a href="#" class="text-white"><i class="bi bi-power"></i></a></button>
        </form>
    </div>
    </nav>

    <!-- Conteúdo principal -->
    <main class="flex-grow bg-gray-100 p-4">
        <h1 class="text-2xl font-bold">Estoque</h1>
        <p class="mt-2">Gerencie seus produtos de forma eficiente no módulo de estoque.</p>

        <!-- Botão para abrir o formulário -->
        <button id="addProductButton" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Adicionar Produto</button>
        <!-- Campo de pesquisa -->
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Pesquisar produto...">

        <!-- Tabela de produtos -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="productTable">
                <!-- Produtos serão inseridos dinamicamente -->
            </tbody>
        </table>
    </main>

    <!-- Modal para adicionar/editar produto -->
    <div id="productModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Nome do Produto</label>
                            <input type="text" id="productName" class="form-control" required>
                        </div>
                        <div class="mb-3">
    <label for="productQuantity" class="form-label">Quantidade</label>
    <input type="number" id="productQuantity" class="form-control" required>
</div>
<div class="mb-3">
    <label for="productUnit" class="form-label">Unidade de Medida</label>
    <select id="productUnit" class="form-control" required>
        <option value="KG">KG</option>
        <option value="Sacos">Sacos</option>
    </select>
</div>

                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Preço</label>
                            <input type="number" step="0.01" id="productPrice" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="saveProductButton" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const productTable = document.getElementById('productTable');
    const searchInput = document.getElementById('searchInput');
    const productModal = new bootstrap.Modal(document.getElementById('productModal'));
    const saveProductButton = document.getElementById('saveProductButton');
    const viewGeneralHistoryButton = document.createElement('button'); // Botão para histórico geral
    let currentProductId = null;
    let products = [];

    // Adicionar botão de Histórico Geral dinamicamente
    viewGeneralHistoryButton.id = 'viewGeneralHistoryButton';
    viewGeneralHistoryButton.className = 'btn btn-secondary mb-3';
    viewGeneralHistoryButton.innerHTML = `<i class="bi bi-clock-history"></i> Histórico Geral`;
    document.querySelector('main').insertBefore(viewGeneralHistoryButton, document.getElementById('addProductButton'));

    // Carregar produtos
    const fetchProducts = async () => {
        try {
            const response = await fetch('/produtos');
            if (!response.ok) throw new Error('Erro ao carregar produtos.');
            products = await response.json();
            displayProducts(products);
        } catch (error) {
            console.error(error);
            alert('Erro ao carregar produtos.');
        }
    };

    // Mostrar produtos na tabela
    const displayProducts = (filteredProducts) => {
        productTable.innerHTML = '';
        if (filteredProducts.length === 0) {
            productTable.innerHTML = '<tr><td colspan="6" class="text-center">Nenhum produto encontrado.</td></tr>';
            return;
        }

        filteredProducts.forEach(product => {
            productTable.innerHTML += `
                <tr>
                    <td>${product.id}</td>
                    <td>${product.nome}</td>
                    <td>${product.quantidade} ${product.unidade}</td>
                    <td>R$ ${parseFloat(product.preco).toFixed(2)}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editProduct(${product.id}, '${product.nome}', ${product.quantidade}, '${product.unidade}', ${product.preco})"><i class="bi bi-pencil"></i> Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})"><i class="bi bi-trash"></i> Excluir</button>
                        <button class="btn btn-info btn-sm" onclick="viewHistory(${product.id})"><i class="bi bi-clock-history"></i> Histórico</button>
                    </td>
                </tr>
            `;
        });
    };

    // Pesquisar produtos
    searchInput.addEventListener('input', () => {
        const searchText = searchInput.value.toLowerCase();
        const filteredProducts = products.filter(product =>
            product.nome.toLowerCase().includes(searchText)
        );
        displayProducts(filteredProducts);
    });

    // Salvar produto (Adicionar ou Editar)
    const saveProduct = async () => {
        const nome = document.getElementById('productName').value;
        const quantidade = parseInt(document.getElementById('productQuantity').value, 10);
        const preco = parseFloat(document.getElementById('productPrice').value);
        const unidade = document.getElementById('productUnit').value;

        if (!nome || quantidade <= 0 || preco <= 0) {
            alert('Preencha todos os campos corretamente.');
            return;
        }

        try {
            const method = currentProductId ? 'PUT' : 'POST';
            const url = currentProductId ? `/produtos/${currentProductId}` : '/produtos';
            const response = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ nome, quantidade, unidade, preco }),
            });

            if (!response.ok) throw new Error('Erro ao salvar produto.');
            alert(`Produto ${currentProductId ? 'atualizado' : 'adicionado'} com sucesso!`);
            productModal.hide();
            fetchProducts();
        } catch (error) {
            console.error(error);
            alert('Erro ao salvar produto.');
        }
    };

    // Excluir produto
    window.deleteProduct = async (id) => {
        if (!confirm('Deseja realmente excluir este produto?')) return;

        try {
            const response = await fetch(`/produtos/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });

            if (!response.ok) throw new Error('Erro ao excluir produto.');
            alert('Produto excluído com sucesso!');
            fetchProducts();
        } catch (error) {
            console.error(error);
            alert('Erro ao excluir produto.');
        }
    };

    // Editar produto
    window.editProduct = (id, nome, quantidade, unidade, preco) => {
        currentProductId = id;
        document.getElementById('productName').value = nome;
        document.getElementById('productQuantity').value = quantidade;
        document.getElementById('productPrice').value = preco;
        document.getElementById('productUnit').value = unidade;
        productModal.show();
    };

    // Ver histórico do produto
    window.viewHistory = async (id) => {
        try {
            const response = await fetch(`/produtos/${id}/historico`);
            if (!response.ok) throw new Error('Erro ao carregar histórico.');

            const history = await response.json();
            let historyHtml = '<ul>';
            history.forEach(item => {
                historyHtml += `<li><strong>${item.acao}</strong>: ${item.quantidade} ${item.unidade} - <em>${item.usuario?.name || 'Usuário desconhecido'}</em> (${new Date(item.created_at).toLocaleString()})</li>`;
            });
            historyHtml += '</ul>';
            alert(`Histórico do Produto:\n${historyHtml}`);
        } catch (error) {
            console.error(error);
            alert('Erro ao carregar histórico.');
        }
    };

    // Ver histórico geral
    viewGeneralHistoryButton.addEventListener('click', async () => {
        try {
            const response = await fetch('/produtos/historico-geral');
            if (!response.ok) throw new Error('Erro ao carregar histórico geral.');

            const history = await response.json();
            let historyHtml = '<ul>';
            history.forEach(item => {
                historyHtml += `<li><strong>${item.acao}</strong>: ${item.quantidade} ${item.unidade} - <em>${item.usuario?.name || 'Usuário desconhecido'}</em> (${new Date(item.created_at).toLocaleString()})</li>`;
            });
            historyHtml += '</ul>';
            alert(`Histórico Geral:\n${historyHtml}`);
        } catch (error) {
            console.error(error);
            alert('Erro ao carregar histórico geral.');
        }
    });

    // Inicializar eventos
    saveProductButton.addEventListener('click', saveProduct);
    document.getElementById('addProductButton').addEventListener('click', () => {
        currentProductId = null;
        document.getElementById('productForm').reset();
        productModal.show();
    });

    // Carregar produtos ao iniciar
    fetchProducts();
});

    </script>
</body>
</html>
