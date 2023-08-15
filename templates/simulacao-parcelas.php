<?php
// templates/simulacao-parcelas.php

$valor_produto = get_post_meta(get_the_ID(), '_regular_price', true);
$valor_minimo_parcela = get_option('valor_minimo_parcela');

$simulacao = '<table class="simulador-parcelamento-table">';
$simulacao .= '<tr><th>Parcelas</th><th>Valor</th></tr>';

for ($i = 1; $i <= 12; $i++) {
    $juros_parcela = get_option('juros_parcela_' . $i);

    if ($i <= $parcelas_sem_juros) {
        $valor_parcela = $valor_produto / $i;
    } else {
        $valor_parcela = ($valor_produto + ($valor_produto * ($juros_parcela / 100))) / $i;
    }

    if ($valor_parcela >= $valor_minimo_parcela) {
        $simulacao .= '<tr><td>' . $i . 'x</td><td>R$' . number_format($valor_parcela, 2, ',', '.') . '</td></tr>';
    }
}

$simulacao .= '</table>';

echo $simulacao;
