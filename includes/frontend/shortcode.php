<?php
// shortcode.php

// Função para gerar a simulação de parcelamento
function simulador_parcelamento_nextstream_simulacao_parcelas() {
    $valor_produto = get_post_meta(get_the_ID(), '_regular_price', true);
    $valor_minimo_parcela = get_option('valor_minimo_parcela');

    $simulacao = '<table>';
    $simulacao .= '<tr><th>Parcelas</th><th>Valor</th></tr>';

    for ($i = 1; $i <= 12; $i++) {
        $juros_parcela = get_option('juros_parcela_' . $i);

        if ($valor_parcela >= $valor_minimo_parcela) {
            $simulacao .= '<tr><td>'        $i . 'x</td><td>R$' . number_format($valor_parcela, 2, ',', '.') . '</td></tr>';
        }
    }

    $simulacao .= '</table>';

    return $simulacao;
}
add_shortcode('simulacao_parcelamento', 'simulador_parcelamento_nextstream_simulacao_parcelas');
