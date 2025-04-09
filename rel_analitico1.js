document.addEventListener("DOMContentLoaded", function() {
    // Carregar opções de Procedimento, Tipo de Pagamento, e Cliente/Dependente
    carregarOpcoes();

    // Adicionar evento de envio ao formulário
    document.getElementById("filtroForm").addEventListener("submit", function(event) {
        event.preventDefault();
        gerarRelatorio();
    });
});

function carregarOpcoes() {
    fetch('get_procedimentos.php')
        .then(response => response.json())
        .then(data => {
            let procedimentoSelect = document.getElementById("procedimento_id");
            data.forEach(procedimento => {
                let option = document.createElement("option");
                option.value = procedimento.id;
                option.textContent = procedimento.nome;
                procedimentoSelect.appendChild(option);
            });
        });

    fetch('get_tipos_pagamento.php')
        .then(response => response.json())
        .then(data => {
            let tipoPagamentoSelect = document.getElementById("tipo_pagamento_id");
            data.forEach(tipo => {
                let option = document.createElement("option");
                option.value = tipo.id;
                option.textContent = tipo.descricao;
                tipoPagamentoSelect.appendChild(option);
            });
        });

    fetch('get_clientes_dependentes.php')
        .then(response => response.json())
        .then(data => {
            let clienteDependenteSelect = document.getElementById("cliente_dependente");
            data.forEach(cliente => {
                let option = document.createElement("option");
                option.value = cliente.id;
                option.textContent = cliente.nome;
                clienteDependenteSelect.appendChild(option);
            });
        });
}

function gerarRelatorio() {
    let formData = new FormData(document.getElementById("filtroForm"));
    fetch('processar_relatorio1.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("report").innerHTML = data;
    });
}

function limparFiltros() {
    document.getElementById("filtroForm").reset();
}

function voltar() {
    window.history.back();
}

function printReport() {
    window.print();
}