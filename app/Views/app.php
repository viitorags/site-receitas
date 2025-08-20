<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Receitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
        }

        .post-card {
            border-radius: 12px;
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .post-title {
            font-size: 1.3rem;
            font-weight: bold;
        }

        .post-meta {
            font-size: 0.85rem;
            color: gray;
            margin-bottom: 10px;
        }

        .post-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>🍲 Receitas</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNovo">➕ Nova Receita</button>
        </div>

        <div id="listaReceitas" class="row g-4">
            <?php foreach ($receitas as $receita) : ?>
                <div class="col-md-6 col-lg-4" id="receita-<?= $receita['id'] ?>">
                    <div class="post-card">
                        <div class="post-title">
                            <?= $receita['titulo']; ?>
                        </div>
                        <div class="post-meta">Descrição:
                            <?= $receita['descricao'] ?>
                        </div>
                        <div><strong>Ingredientes:</strong><br>
                            <?= $receita['ingredientes'] ?>
                        </div>
                        <div><strong>Modo de Preparo:</strong><br>
                            <?= $receita['modo_preparo'] ?>
                        </div>
                        <div class="post-actions">
                            <button class="btn btn-warning btn-sm"
                                onclick="abrirEditar(<?= $receita['id'] ?>, '<?= addslashes($receita['titulo']) ?>', '<?= addslashes($receita['descricao']) ?>', '<?= addslashes($receita['ingredientes']) ?>', '<?= addslashes($receita['modo_preparo']) ?>')">
                                Editar
                            </button>
                            <button class="btn btn-danger btn-sm" data-id="<?= $receita['id'] ?>"
                                data-titulo="<?= addslashes($receita['titulo']) ?>" onclick="excluir(this)">
                                Excluir
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <div class="modal fade" id="modalNovo" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formReceita" action="/" method="POST">
                    <input type="hidden" name="acao" value="criar">
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" name="titulo" class="form-control" placeholder="Título da receita"
                                required>
                        </div>
                        <div class="mb-3">
                            <textarea name="descricao" class="form-control" rows="2" placeholder="Descrição"></textarea>
                        </div>
                        <div class="mb-3">
                            <textarea name="ingredientes" class="form-control" rows="3" placeholder="Ingredientes"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <textarea name="modo_preparo" class="form-control" rows="3" placeholder="Modo de preparo"
                                required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar Receita</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEditar" action="/" method="POST">
                    <input type="hidden" name="acao" value="atualizar">
                    <input type="hidden" name="id" id="editId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" name="titulo" id="editTitulo" class="form-control" placeholder="Título"
                                required>
                        </div>
                        <div class="mb-3">
                            <textarea name="descricao" id="editDescricao" class="form-control" rows="2"
                                placeholder="Descrição"></textarea>
                        </div>
                        <div class="mb-3">
                            <textarea name="ingredientes" id="editIngredientes" class="form-control" rows="3"
                                placeholder="Ingredientes" required></textarea>
                        </div>
                        <div class="mb-3">
                            <textarea name="modo_preparo" id="editModo" class="form-control" rows="3"
                                placeholder="Modo de preparo" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="formDelete" action="/" method="post" style="display:none;">
        <input type="hidden" name="acao" value="excluir">
        <input type="hidden" name="id" id="deleteId">
        <input type="hidden" name="titulo" , id="deleteTitulo">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function mostrarAlerta(tipo, mensagem) {
            const alerta = document.createElement("div");
            alerta.className = `alert alert-${tipo} position-fixed top-0 end-0 m-3`;
            alerta.style.zIndex = "1055";
            alerta.textContent = mensagem;
            document.body.appendChild(alerta);

            setTimeout(() => alerta.remove(), 3000);
        }

        window.addEventListener("load", () => {
            const alerta = sessionStorage.getItem("alerta");
            if (alerta) {
                const {
                    tipo,
                    mensagem
                } = JSON.parse(alerta);
                mostrarAlerta(tipo, mensagem);
                sessionStorage.removeItem("alerta");
            }
        });

        function abrirEditar(id, titulo, descricao, ingredientes, modo_preparo) {
            document.getElementById("editId").value = id;
            document.getElementById("editTitulo").value = titulo;
            document.getElementById("editDescricao").value = descricao;
            document.getElementById("editIngredientes").value = ingredientes;
            document.getElementById("editModo").value = modo_preparo;
            new bootstrap.Modal(document.getElementById("modalEditar")).show();
        }

        document.getElementById("formReceita").addEventListener("submit", function(e) {
            e.preventDefault();

            const data = {
                titulo: this.titulo.value,
                descricao: this.descricao.value,
                ingredientes: this.ingredientes.value,
                modo_preparo: this.modo_preparo.value
            };

            fetch('/api/receitas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        location.reload();
                        sessionStorage.setItem("alerta", JSON.stringify({
                            tipo: "success",
                            mensagem: "Receita criada com sucesso!"
                        }));
                    } else {
                        mostrarAlerta("danger", "Erro ao criar receita");
                    }
                })
                .catch(err => console.error(err));
        });

        document.getElementById("formEditar").addEventListener("submit", function(e) {
            e.preventDefault();
            const id = this.id.value;

            const data = {
                id: this.id.value,
            };

            fetch(`api/receitas`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        location.reload();
                        sessionStorage.setItem("alerta", JSON.stringify({
                            tipo: "success",
                            mensagem: "Receita atualizada com sucesso!"
                        }));
                    } else {
                        mostrarAlerta("danger", "Erro ao atualizar receita");
                    }
                })
                .catch(err => console.error(err));
        });

        function excluir(botao) {
            if (!confirm("Tem certeza que deseja excluir esta receita?")) return;

            const id = botao.dataset.id;
            const titulo = botao.dataset.titulo;

            fetch(`api/receitas`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id
                    })
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        mostrarAlerta("success", `Receita: ${titulo} deletada com sucesso`);
                        const card = document.getElementById(`receita-${id}`);
                        if (card) card.remove();
                    } else {
                        mostrarAlerta("danger", "Erro ao deletar receita");
                    }
                })
                .catch(err => console.error(err));
        }
    </script>

</body>

</html>
