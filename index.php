<?php
include_once "Cripto.php";
$cripto = new Cripto;
$cripto->Database();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio CriptoMoedas</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div id="conteudo">

        <div id="centro_lista">

            <div id="centro_lista_topo">
                <span class="titulo">Recursos</span>
                <span class="button" onclick="adicionar()">Adicionar</span>
            </div>

            <div id="centro_lista_tabela_head">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <th class="column0">Wallet</th>
                        <th class="column1">Token</th>
                        <th class="column3">Preço Atual</th>
                        <th class="column4">Saldo</th>
                        <th class="column5">Ações</th>
                    </tr>
                </table>
            </div>

            <div class="clear"></div>

            <div id="centro_lista_tabela">
                <table id="dados" width="100%" cellspacing="0" cellpadding="0">
                    <?php
                    $geral = 0;
                    foreach ($cripto->index() as $crip) {
                        $id = $crip['id'];
                        $wallet = $crip['wallet'];
                        $balance = (float)$crip['balance'];
                        $image = $cripto->consultaApi($crip['api_id'], 'image');
                        $name = $cripto->consultaApi($crip['api_id'], 'name');
                        $symbol = $cripto->consultaApi($crip['api_id'], 'symbol');
                        $price = (float)$cripto->consultaApi($crip['api_id'], 'price');
                        $perc24h = $cripto->consultaApi($crip['api_id'], 'perc24h');
                        $color = 'variantGreen';
                        if ($perc24h < 0) $color = 'variantRed';
                        $geral += $balance * $price;
                    ?>
                        <tr class="data">
                            <td class="column0">
                                <img src="./images/<?= strtolower($wallet) ?>.png" width="32px" height="auto" />
                            </td>
                            <td class="column1">
                                <img src="<?= $image ?>" width="28" height="28" />
                                <div class="cripto"><span class="abv"><?= $symbol ?></span><span class="nome"><?= $name ?></span></div>
                            </td>
                            <td class="column3"><span class="price">$ <?= number_format($price, 2, ',', '.') ?></span><span class="<?= $color ?>"><?= number_format($perc24h, 1, '.', '') ?> %</span></td>
                            <td class="column4"><span class="balance">$ <?= number_format($price * $balance, 2, ',', '.') ?></span><span class="cripto"><?= number_format($balance, 8, '.', '') ?> <?= $symbol ?></span></td>
                            <td class="column5">
                                <span class="button" onclick="remover(<?= $id ?>, '<?= $name ?>', '<?= $wallet ?>')">Remover</span> <span class="button" onclick="alterar(<?= $id ?>)">Alterar</span>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

        </div>

        <div id="centro_topo">
            <div id="centro_topo_total">
                <span class="titulo">Saldo Geral:</span>
                <span class="saldo">$ <?= number_format($geral, 2, ',', '.') ?></span>
            </div>

        </div>

    </div>

    <script src="./js/scripts.js"></script>
</body>

</html>