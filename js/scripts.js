async function adicionar() {
    var form = new FormData()
    form.append('wallet', prompt("Informe a carteira que está a moeda."))
    form.append('api_id', prompt("Informe a API ID."))
    form.append('balance', prompt("Informe o seu saldo atual."))

    await fetch('./acao.php?acao=adicionar', {
        method: "POST",
        body: form
    })
        .then((data) => {
            window.location.reload(true);
        })
        .catch((error) => {
            console.error('Error:', error)
        });
}

async function alterar(id) {
    var form = new FormData()
    form.append('id', id)
    form.append('balance', prompt("Informe o novo saldo."))

    await fetch('./acao.php?acao=alterar', {
        method: "POST",
        body: form
    })
        .then((data) => {
            window.location.reload(true);
        })
        .catch((error) => {
            console.error('Error:', error)
        });
}

async function remover(id, name, wallet) {
    if (confirm(`Deseja realmente remover ${name}, que está na carteira ${wallet} ?`)) {
        var form = new FormData()
        form.append('id', id)

        await fetch('./acao.php?acao=remover', {
            method: "POST",
            body: form
        })
            .then((data) => {
                window.location.reload(true);
            })
            .catch((error) => {
                console.error('Error:', error)
            });
    }
}
