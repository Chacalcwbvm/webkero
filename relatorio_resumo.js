document.addEventListener('DOMContentLoaded', function() {
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

    fetch('obter_procedimentos.php')
    .then(response => response.json())
    .then(data => {
        const procedimentosDiv = document.getElementById('procedimentos');
        data.forEach(item => {
            const label = document.createElement('label');
            label.innerHTML = `<input type="checkbox" name="procedimentos[]" value="${item.id}"> ${item.nome}`;
            procedimentosDiv.appendChild(label);
        });
    });

    fetch('obter_tipos_pagamento.php')
    .then(response => response.json())
    .then(data => {
        const tiposPagamentoDiv = document.getElementById('tipo_pagamento');
        data.forEach(item => {
            const label = document.createElement('label');
            label.innerHTML = `<input type="checkbox" name="tipo_pagamento[]" value="${item.id}"> ${item.descricao}`;
            tiposPagamentoDiv.appendChild(label);
        });
    });

    document.getElementById('filtroForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        const progressBar = document.getElementById("progress-bar");

        fetch('gerar_relatorio_resumo.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            const reader = response.body.getReader();
            let contentLength = response.headers.get("Content-Length");
            let receivedLength = 0;
            let chunks = [];

            reader.read().then(function processText({ done, value }) {
                if (done) {
                    let chunksAll = new Uint8Array(receivedLength);
                    let position = 0;
                    for (let chunk of chunks) {
                        chunksAll.set(chunk, position);
                        position += chunk.length;
                    }
                    let result = new TextDecoder("utf-8").decode(chunksAll);
                    document.getElementById("report").innerHTML = result;
                    progressBar.style.width = "100%";
                    return;
                }

                chunks.push(value);
                receivedLength += value.length;

                if (contentLength) {
                    progressBar.style.width = `${(receivedLength / contentLength) * 100}%`;
                }

                return reader.read().then(processText);
            });
        });
    });

    function limparFiltros() {
        document.getElementById('filtroForm').reset();
        document.getElementById('report').innerHTML = '';
        fetch('gerar_relatorio_resumo.php', {
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
        window.location.href = 'index.html';
    }
});