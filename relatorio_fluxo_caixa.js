document.addEventListener('DOMContentLoaded', function() {
    fetch('obter_tipos_atendimento.php')
    .then(response => response.json())
    .then(data => {
        const tipoAtendimentoSelect = document.getElementById('tipo_atendimento');
        data.forEach(tipo => {
            const option = document.createElement('option');
            option.value = tipo.id;
            option.textContent = tipo.nome;
            tipoAtendimentoSelect.appendChild(option);
        });
    });

    fetch('obter_clientes.php')
    .then(response => response.json())
    .then(data => {
        const clienteSelect = document.getElementById('cliente');
        data.forEach(cliente => {
            const option = document.createElement('option');
            option.value = cliente.id;
            option.textContent = cliente.nome;
            clienteSelect.appendChild(option);
        });
    });

    fetch('obter_dependentes.php')
    .then(response => response.json())
    .then(data => {
        const dependenteSelect = document.getElementById('dependente');
        data.forEach(dependente => {
            const option = document.createElement('option');
            option.value = dependente.id;
            option.textContent = dependente.nome;
            dependenteSelect.appendChild(option);
        });
    });

    document.getElementById('filtroForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        fetch('gerar_relatorio_fluxo_caixa.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('report').innerHTML = data;
            addSortEventListeners();
        });
    });

    // Gera relatório completo ao carregar a página
    fetch('gerar_relatorio_fluxo_caixa.php', {
        method: 'POST',
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('report').innerHTML = data;
        addSortEventListeners();
    });
});

function limparFiltros() {
    document.getElementById('filtroForm').reset();
    document.getElementById('report').innerHTML = '';
    // Gera relatório completo ao limpar filtros
    fetch('gerar_relatorio_fluxo_caixa.php', {
        method: 'POST',
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('report').innerHTML = data;
        addSortEventListeners();
    });
}

function printReport() {
    var printContents = document.getElementById('report').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

function addSortEventListeners() {
    const headers = document.querySelectorAll('.report th');
    headers.forEach(header => {
        header.addEventListener('click', function() {
            sortTable(this.cellIndex);
        });
    });
}

function sortTable(n) {
    var table = document.querySelector('.report table');
    var rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    switching = true;
    dir = "asc"; 
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++; 
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

function voltar() {
    window.location.href = '/aa_04_krcrm/new/rel/topbar_menu.php'
}