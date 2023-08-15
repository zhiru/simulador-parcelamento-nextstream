<?php
// frontend.php
function simulador_parcelamento_nextstream_enqueue_styles() {
    wp_enqueue_style( 'simulador-parcelamento-styles', plugins_url( 'assets/css/style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'simulador_parcelamento_nextstream_enqueue_styles' );

// Função para gerar a simulação de parcelamento
function simulador_parcelamento_nextstream_simulacao_parcelas()
{
    $valor_produto = get_post_meta(get_the_ID(), '_sale_price', true);
    $valor_minimo_parcela = get_option('valor_minimo_parcela');

    // Obter as opções de estilo
    $tamanho_fonte_parcelas = get_option('tamanho_fonte_parcelas');
    $peso_fonte_parcelas = get_option('peso_fonte_parcelas');
    $cor_fonte_parcelas = get_option('cor_fonte_parcelas');

    $tamanho_fonte_texto = get_option('tamanho_fonte_texto');
    $peso_fonte_texto = get_option('peso_fonte_texto');
    $cor_fonte_texto = get_option('cor_fonte_texto');

    $tamanho_fonte_valor_parcelas = get_option('tamanho_fonte_valor_parcelas');
    $peso_fonte_valor_parcelas = get_option('peso_fonte_valor_parcelas');
    $cor_fonte_valor_parcelas = get_option('cor_fonte_valor_parcelas');

    // Inicializando a variável com o padrão de 0 parcelas sem juros
    $parcelas_sem_juros = 0;

    // Verificando quantos campos do 'juros_parcela_'.$i estão com o valor vazio ou 0
    for ($i = 1; $i <= 6; $i++) {
        $juros_parcela = get_option('juros_parcela_' . $i);
        if (empty($juros_parcela) || $juros_parcela == 0) {
            $parcelas_sem_juros++;
        }
    }

    $simulacao = '<div class="simulador-parcelamento">';
    $simulacao .= '<div class="simulador-parcelamento-columns">';
    $simulacao .= '<div class="simulador-parcelamento-column">';

    for ($i = 1; $i <= 6; $i++) {
        $juros_parcela = get_option('juros_parcela_' . $i);

        if ($i <= $parcelas_sem_juros) {
            $valor_parcela = $valor_produto / $i;
            $texto_parcela = 'R$' . number_format($valor_parcela, 2, ',', '.');
            if ($juros_parcela <= 0) {
                $texto_parcela .= ' <span class="simulador-parcelamento-de">sem juros</span>';
            }
        } else {
            if ($juros_parcela > 0) {
                $valor_parcela = ($valor_produto + ($valor_produto * ($juros_parcela / 100))) / $i;
                $texto_parcela = 'R$' . number_format($valor_parcela, 2, ',', '.');
            } else {
                $valor_parcela = $valor_produto / $i;
                $texto_parcela = 'R$' . number_format($valor_parcela, 2, ',', '.') . 
					' <span class="simulador-parcelamento-de" style="font-weight: ' . 
					$peso_fonte_texto.';color: ' . $cor_fonte_texto . ';font-size: ' . $tamanho_fonte_texto . ';">sem juros</span>';
            }
        }

        if ($valor_parcela >= $valor_minimo_parcela) {
            // Adicione as classes de estilo com base nas opções definidas
            $simulacao .= '<div class="simulador-parcelamento-item" style="';
            $simulacao .= 'font-size: ' . $tamanho_fonte_parcelas . '; ';
            $simulacao .= 'font-weight: ' . $peso_fonte_parcelas . '; ';
            $simulacao .= 'color: ' . $cor_fonte_parcelas . '; ';
            $simulacao .= '">';
            $simulacao .= $i . 'x <span class="simulador-parcelamento-de" style="';
            $simulacao .= 'font-size: ' . $tamanho_fonte_texto . '; ';
            $simulacao .= 'font-weight: ' . $peso_fonte_texto . '; ';
            $simulacao .= 'color: ' . $cor_fonte_texto . '; ';
            $simulacao .= '">de</span> ';
            $simulacao .= '<span class="simulador-parcelamento-valor" style="';
            $simulacao .= 'font-size: ' . $tamanho_fonte_valor_parcelas . '; ';
            $simulacao .= 'font-weight: ' . $peso_fonte_valor_parcelas . '; ';
            $simulacao .= 'color: ' . $cor_fonte_valor_parcelas . '; ';
            $simulacao .= '">' . $texto_parcela . '</span>';
            $simulacao .= '</div>';
        }
    }

    $simulacao .= '</div>';
    $simulacao .= '<div class="simulador-parcelamento-column2">';

    for ($i = 7; $i <= 12; $i++) {
        $juros_parcela = get_option('juros_parcela_' . $i);

        if ($i <= $parcelas_sem_juros) {
            $valor_parcela = $valor_produto / $i;
            $texto_parcela = 'R$' . number_format($valor_parcela, 2, ',', '.');
            if ($juros_parcela <= 0) {
                $texto_parcela .= ' <span class="simulador-parcelamento-de">sem juros</span>';
            }
        } else {
            if ($juros_parcela > 0) {
                $valor_parcela = ($valor_produto + ($valor_produto * ($juros_parcela / 100))) / $i;
                $texto_parcela = 'R$' . number_format($valor_parcela, 2, ',', '.');
            } else {
                $valor_parcela = $valor_produto / $i;
                $texto_parcela = 'R$' . number_format($valor_parcela, 2, ',', '.') . 
					' <span class="simulador-parcelamento-de" style="font-weight: ' . 
					$peso_fonte_texto.';color: ' . $cor_fonte_texto . ';font-size: ' . $tamanho_fonte_texto . ';">sem juros</span>';
            }
        }

        if ($valor_parcela >= $valor_minimo_parcela) {
            // Adicione as classes de estilo com base nas opções definidas
            $simulacao .= '<div class="simulador-parcelamento-item" style="';
            $simulacao .= 'font-size: ' . $tamanho_fonte_parcelas . '; ';
            $simulacao .= 'font-weight: ' . $peso_fonte_parcelas . '; ';
            $simulacao .= 'color: ' . $cor_fonte_parcelas . '; ';
            $simulacao .= '">';
            $simulacao .= $i . 'x <span class="simulador-parcelamento-de" style="';
            $simulacao .= 'font-size: ' . $tamanho_fonte_texto . '; ';
            $simulacao .= 'font-weight: ' . $peso_fonte_texto . '; ';
            $simulacao .= 'color: ' . $cor_fonte_texto . '; ';
            $simulacao .= '">de</span> ';
            $simulacao .= '<span class="simulador-parcelamento-valor" style="';
            $simulacao .= 'font-size: ' . $tamanho_fonte_valor_parcelas . '; ';
            $simulacao .= 'font-weight: ' . $peso_fonte_valor_parcelas . '; ';
            $simulacao .= 'color: ' . $cor_fonte_valor_parcelas . '; ';
            $simulacao .= '">' . $texto_parcela . '</span>';
            $simulacao .= '</div>';
        }
    }

    $simulacao .= '</div>';
    $simulacao .= '</div>';
    $simulacao .= '</div>';

    return $simulacao;
}

add_shortcode('simulacao_parcelamento', 'simulador_parcelamento_nextstream_simulacao_parcelas');
