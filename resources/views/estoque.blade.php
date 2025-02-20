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

    <!-- Barra Superior -->
    <header class="bg-gray-300 text-black py-3 px-4 d-flex align-items-center justify-content-between fixed-top" style="margin-left: 250px; height: 60px; width: calc(100% - 250px);">
        <h2 class="text-lg font-semibold">Online</h2>
        <div class="text-nowrap" style="padding-right: 20px;">
            Olá, {{ Auth::check() ? Auth::user()->name : 'Visitante' }}!
        </div>
    </header>

    <!-- Barra de navegação -->
    <nav class="bg text-white d-flex flex-column justify-content-between" style="width: 250px; min-height: 100vh;">
        <div>
            <div class="text-center mb-4 mt-4">
                <a href="{{ route('dashboard') }}">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="/img/logo-sistema.png" width="80px" alt="Logo">
                    </div>
                    <h2 class="titulo mt-2 text-center">EvolvERP</h2>
                </a>
            </div>
            <p class="text-uppercase text-secondary text-center">Menu Sistema</p>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="/estoque" class="nav-link text-white active"><i class="bi bi-box"></i> Estoque</a></li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <main class="flex-grow bg-gray-100 p-4">
        <h1 class="text-2xl font-bold mt-5">Estoque</h1>
        <p class="mt-2">Gerencie seus produtos de forma eficiente no módulo de estoque.</p>

        <!-- Botões principais -->
        <button id="addProductButton" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Adicionar Produto</button>
        <button class="btn btn-secondary mb-3" onclick="openMovementModal(1, 'Produto A')"><i class="bi bi-arrow-right"></i>Registrar Movimentação</button>
        <!-- Botão para abrir o formulário de cadastro de cliente -->
        <button id="addClientButton" class="btn btn-success mb-3">
    <i class="bi bi-person-plus"></i> Adicionar Cliente
</button>







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

    <!-- Modal para registrar movimentação -->
    <div id="movementModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Movimentação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="movementForm">
                        <div class="mb-3">
                            <label for="movementProduct" class="form-label">Produto</label>
                            <select id="movementProduct" class="form-control" required></select>
                        </div>
                        <div class="mb-3">
                            <label for="movementQuantity" class="form-label">Quantidade</label>
                            <input type="number" id="movementQuantity" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="movementClient" class="form-label">Cliente</label>
                            <input type="text" id="movementClient" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="saveMovementButton" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="clientModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="clientForm">
                    <div class="mb-3">
                        <label for="clientName" class="form-label">Nome</label>
                        <input id="clientName" type="text" class="form-control" placeholder="Nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="clientEmail" class="form-label">E-mail</label>
                        <input id="clientEmail" type="email" class="form-control" placeholder="E-mail" required>
                    </div>
                    <div class="mb-3">
                        <label for="clientPhone" class="form-label">Telefone</label>
                        <input id="clientPhone" type="text" class="form-control" placeholder="Telefone" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="saveClientButton" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const clientModal = new bootstrap.Modal(document.getElementById('clientModal'), { backdrop: 'static' });

    let currentClientId = null;

    // Abrir modal para adicionar cliente
    document.getElementById('addClientButton').addEventListener('click', () => {
        currentClientId = null;
        document.getElementById('clientForm').reset();
        clientModal.show();
    });

    // Abrir modal para editar cliente
    window.editClient = (id, nome, email, telefone) => {
        currentClientId = id;
        document.getElementById('clientName').value = nome;
        document.getElementById('clientEmail').value = email;
        document.getElementById('clientPhone').value = telefone;
        clientModal.show();
    };

    // Salvar cliente (Adicionar ou Editar)
    const saveClient = async () => {
        const nome = document.getElementById('clientName').value.trim();
        const email = document.getElementById('clientEmail').value.trim();
        const telefone = document.getElementById('clientPhone').value.trim();

        if (!nome || !email || !telefone) {
            Swal.fire('Atenção', 'Preencha todos os campos corretamente.', 'warning');
            return;
        }

        try {
            const method = currentClientId ? 'PUT' : 'POST';
            const url = currentClientId ? `/clientes/${currentClientId}` : '/clientes';
            const response = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ nome, email, telefone }),
            });

            if (!response.ok) throw new Error(await response.text());
            
            Swal.fire('Sucesso', `Cliente ${currentClientId ? 'atualizado' : 'adicionado'} com sucesso!`, 'success');
            clientModal.hide(); // Fechar o modal
            fetchClients(); // Recarregar lista de clientes
        } catch (error) {
            console.error(error);
            Swal.fire('Erro', error.message || 'Erro ao salvar cliente.', 'error');
        }
    };

    // Inicializar evento para salvar cliente
    document.getElementById('saveClientButton').addEventListener('click', saveClient);

    // Função para buscar clientes
    const fetchClients = async () => {
        try {
            const response = await fetch('/clientes');
            if (!response.ok) throw new Error('Erro ao carregar clientes.');
            return await response.json();
        } catch (error) {
            console.error(error);
            Swal.fire('Erro', 'Erro ao carregar clientes.', 'error');
        }
    };

    // Abrir modal de movimentação
    window.openMovementModal = async (productId, productName) => {
        const clients = await fetchClients();
        if (!clients || clients.length === 0) {
            Swal.fire('Atenção', 'Nenhum cliente cadastrado.', 'warning');
            return;
        }

        let clientOptions = '';
        clients.forEach(client => {
            clientOptions += `<option value="${client.id}">${client.nome}</option>`;
        });

        Swal.fire({
            title: `Registrar Movimentação para ${productName}`,
            html: `
                <label for="movementQuantity">Quantidade:</label>
                <input type="number" id="movementQuantity" class="swal2-input" min="1" required>
                <label for="movementClient">Cliente:</label>
                <select id="movementClient" class="swal2-input">${clientOptions}</select>
            `,
            showCancelButton: true,
            confirmButtonText: 'Registrar',
            preConfirm: () => {
                return {
                    quantity: document.getElementById('movementQuantity').value,
                    clientId: document.getElementById('movementClient').value,
                };
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const { quantity, clientId } = result.value;
                    const response = await fetch(`/produtos/movimentar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ productId, quantity, client: clientId }),
                    });

                    if (!response.ok) throw new Error('Erro ao registrar movimentação.');
                    Swal.fire('Sucesso', 'Movimentação registrada com sucesso!', 'success');
                } catch (error) {
                    console.error(error);
                    Swal.fire('Erro', 'Erro ao registrar movimentação.', 'error');
                }
            }
        });
    };

    // Ver histórico de movimentação
    window.viewMovementHistory = async () => {
        try {
            const response = await fetch(`/produtos/movimentacoes`);
            if (!response.ok) throw new Error('Erro ao carregar histórico de movimentação.');

            const history = await response.json();
            let historyHtml = '<ul>';
            history.forEach(item => {
                historyHtml += `<li><strong>${item.produto?.nome || 'Produto Desconhecido'}</strong>: ${item.quantidade} ${item.unidade} - Cliente: ${item.cliente?.nome || 'Não informado'} - <em>${new Date(item.created_at).toLocaleString()}</em></li>`;
            });
            historyHtml += '</ul>';
            Swal.fire({
                title: 'Histórico de Movimentações',
                html: historyHtml,
                icon: 'info',
            });
        } catch (error) {
            console.error(error);
            Swal.fire('Erro', 'Erro ao carregar histórico de movimentação.', 'error');
        }
    };
});
</script>


    <script>
document.addEventListener('DOMContentLoaded', () => {
    const productTable = document.getElementById('productTable');
    const searchInput = document.getElementById('searchInput');
    const productModal = new bootstrap.Modal(document.getElementById('productModal'));
    const saveProductButton = document.getElementById('saveProductButton');
    const viewGeneralHistoryButton = document.createElement('button'); // Botão para histórico geral
    const clientModal = new bootstrap.Modal(document.getElementById('clientModal'));
    const saveClientButton = document.getElementById('saveClientButton');
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
            Swal.fire('Erro', 'Erro ao carregar produtos.', 'error');
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
                        <button class="btn btn-primary btn-sm" onclick="openMovementModal(${product.id}, '${product.nome}')"><i class="bi bi-arrow-right"></i> Movimentar</button>
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
            Swal.fire('Atenção', 'Preencha todos os campos corretamente.', 'warning');
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
            Swal.fire('Sucesso', `Produto ${currentProductId ? 'atualizado' : 'adicionado'} com sucesso!`, 'success');
            productModal.hide();
            fetchProducts();
        } catch (error) {
            console.error(error);
            Swal.fire('Erro', 'Erro ao salvar produto.', 'error');
        }
    };

    // Excluir produto
    window.deleteProduct = async (id) => {
        Swal.fire({
            title: 'Tem certeza?',
            text: 'Você deseja realmente excluir este produto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar',
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/produtos/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    });

                    if (!response.ok) throw new Error('Erro ao excluir produto.');
                    Swal.fire('Sucesso', 'Produto excluído com sucesso!', 'success');
                    fetchProducts();
                } catch (error) {
                    console.error(error);
                    Swal.fire('Erro', 'Erro ao excluir produto.', 'error');
                }
            }
        });
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
            Swal.fire({
                title: 'Histórico do Produto',
                html: historyHtml,
                icon: 'info',
            });
        } catch (error) {
            console.error(error);
            Swal.fire('Erro', 'Erro ao carregar histórico.', 'error');
        }
    };

    // Ver histórico geral com filtro de datas
    viewGeneralHistoryButton.addEventListener('click', async () => {
        const { value: formValues } = await Swal.fire({
            title: 'Filtrar Histórico Geral',
            html:
                '<label for="startDate">Data Inicial:</label>' +
                '<input type="date" id="startDate" class="swal2-input">' +
                '<label for="endDate">Data Final:</label>' +
                '<input type="date" id="endDate" class="swal2-input">',
            focusConfirm: false,
            preConfirm: () => {
                return {
                    startDate: document.getElementById('startDate').value,
                    endDate: document.getElementById('endDate').value,
                };
            }
        });

        if (!formValues) return;

        try {
            const query = new URLSearchParams({
                start_date: formValues.startDate,
                end_date: formValues.endDate,
            });

            const response = await fetch(`/produtos/historico-geral?${query}`);
            if (!response.ok) throw new Error('Erro ao carregar histórico geral.');

            const history = await response.json();
            let historyHtml = '<ul>';
            history.forEach(item => {
                historyHtml += `<li><strong>${item.acao}</strong>: ${item.quantidade} ${item.unidade} - <em>${item.usuario?.name || 'Usuário desconhecido'}</em> (${new Date(item.created_at).toLocaleString()})</li>`;
            });
            historyHtml += '</ul>';
            Swal.fire({
                title: 'Histórico Geral',
                html: historyHtml,
                icon: 'info',
            });
        } catch (error) {
            console.error(error);
            Swal.fire('Erro', 'Erro ao carregar histórico geral.', 'error');
        }
    });

    

    // Função para registrar movimentação
    const fetchClients = async () => {
        try {
            const response = await fetch('/clientes');
            if (!response.ok) throw new Error('Erro ao carregar clientes.');
            return await response.json();
        } catch (error) {
            console.error(error);
            Swal.fire('Erro', 'Erro ao carregar clientes.', 'error');
        }
    };

    window.openMovementModal = async (productId, productName) => {
        const clients = await fetchClients();
        if (!clients || clients.length === 0) {
            Swal.fire('Atenção', 'Nenhum cliente cadastrado.', 'warning');
            return;
        }

        let clientOptions = '';
        clients.forEach(client => {
            clientOptions += `<option value="${client.id}">${client.nome}</option>`;
        });

        Swal.fire({
            title: `Registrar Movimentação para ${productName}`,
            html: `
                <label for="movementQuantity">Quantidade:</label>
                <input type="number" id="movementQuantity" class="swal2-input">
                <label for="movementClient">Cliente:</label>
                <select id="movementClient" class="swal2-input">${clientOptions}</select>
            `,
            showCancelButton: true,
            confirmButtonText: 'Registrar',
            preConfirm: () => {
                return {
                    quantity: document.getElementById('movementQuantity').value,
                    clientId: document.getElementById('movementClient').value,
                };
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const { quantity, clientId } = result.value;
                    const response = await fetch(`/produtos/movimentar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ productId, quantity, client: clientId }),
                    });

                    if (!response.ok) throw new Error('Erro ao registrar movimentação.');
                    Swal.fire('Sucesso', 'Movimentação registrada com sucesso!', 'success');
                    fetchProducts();
                } catch (error) {
                    console.error(error);
                    Swal.fire('Erro', 'Erro ao registrar movimentação.', 'error');
                }
            }
        });
    };


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
