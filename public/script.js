document.addEventListener('DOMContentLoaded', () => {
    // Ativar link selecionado na barra de navegação
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navLinks.forEach(item => item.classList.remove('active')); // Remove a classe 'active' de todos
            link.classList.add('active'); // Adiciona a classe 'active' ao link clicado
        });
    });

    const productTable = document.getElementById('productTable');
    const addProductModal = new bootstrap.Modal(document.getElementById('addProductModal'));
    const saveProductButton = document.getElementById('saveProductButton');

    // Carregar produtos do banco de dados
    const fetchProducts = async () => {
        try {
            const response = await fetch('/produtos'); // Atualizando para usar a rota correta
            if (!response.ok) throw new Error('Erro ao buscar produtos');
            const products = await response.json();

            productTable.innerHTML = ''; // Limpa a tabela antes de adicionar os produtos
            products.forEach(product => {
                productTable.innerHTML += `
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.nome}</td>
                        <td>${product.quantidade}</td>
                        <td>R$ ${product.preco.toFixed(2)}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editProduct(${product.id})">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">
                                <i class="bi bi-trash"></i> Excluir
                            </button>
                        </td>
                    </tr>
                `;
            });
        } catch (error) {
            console.error('Erro ao carregar produtos:', error);
        }
    };

    // Adicionar produto
    const addProduct = async () => {
        const nome = document.getElementById('productName').value;
        const quantidade = parseInt(document.getElementById('productQuantity').value);
        const preco = parseFloat(document.getElementById('productPrice').value);

        if (nome && quantidade > 0 && preco > 0) {
            try {
                const response = await fetch('/produtos', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nome, quantidade, preco }),
                });
                if (!response.ok) throw new Error('Erro ao adicionar produto');
                alert('Produto adicionado com sucesso!');
                addProductModal.hide();
                fetchProducts();
            } catch (error) {
                console.error('Erro ao adicionar produto:', error);
                alert('Erro ao adicionar o produto.');
            }
        } else {
            alert('Por favor, preencha todos os campos corretamente.');
        }
    };

    // Editar produto
    window.editProduct = async (id) => {
        const nome = prompt('Novo nome do produto:');
        const quantidade = parseInt(prompt('Nova quantidade:'));
        const preco = parseFloat(prompt('Novo preço:'));

        if (nome && quantidade > 0 && preco > 0) {
            try {
                const response = await fetch(`/produtos/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nome, quantidade, preco }),
                });
                if (!response.ok) throw new Error('Erro ao atualizar produto');
                alert('Produto atualizado com sucesso!');
                fetchProducts();
            } catch (error) {
                console.error('Erro ao atualizar produto:', error);
                alert('Erro ao atualizar o produto.');
            }
        } else {
            alert('Por favor, preencha todos os campos corretamente.');
        }
    };

    // Excluir produto
    window.deleteProduct = async (id) => {
        if (confirm('Tem certeza que deseja excluir este produto?')) {
            try {
                const response = await fetch(`/produtos/${id}`, { method: 'DELETE' });
                if (!response.ok) throw new Error('Erro ao excluir produto');
                alert('Produto excluído com sucesso!');
                fetchProducts();
            } catch (error) {
                console.error('Erro ao excluir produto:', error);
                alert('Erro ao excluir o produto.');
            }
        }
    };

    // Exibir modal de adicionar produto
    document.getElementById('addProductButton').addEventListener('click', () => {
        document.getElementById('productForm').reset(); // Limpa o formulário
        addProductModal.show(); // Exibe o modal
    });

    // Salvar novo produto
    saveProductButton.addEventListener('click', addProduct);

    // Carregar produtos ao iniciar
    fetchProducts();
});
