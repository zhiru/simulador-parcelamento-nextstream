<?php
function simulador_parcelamento_nextstream_enqueue_scripts() {
    //wp_enqueue_script('simulador-parcelamento-scripts', plugins_url('assets/js/simulador.js', SPNEXT_DIR), array('jquery'), null, true);
    wp_enqueue_script(SPNEXT_SLUG . '-frontend-js', SPNEXT_URL . 'assets/js/simulador.js', array('jquery'), SPNEXT_VERSION, true);

    // Localize o script para passar dados para o JavaScript
    wp_localize_script('simulador-parcelamento-scripts', 'simulador_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'simulador_parcelamento_nextstream_enqueue_scripts');


// frontend.php
function simulador_parcelamento_nextstream_enqueue_styles() {
    // wp_enqueue_style( 'simulador-parcelamento-styles', plugins_url( 'assets/css/style.css', SPNEXT_DIR ) );    
    wp_enqueue_style(SPNEXT_SLUG . '-frontend-css', SPNEXT_URL . 'assets/css/style.css', array(), SPNEXT_VERSION, 'all');
}
add_action( 'wp_enqueue_scripts', 'simulador_parcelamento_nextstream_enqueue_styles' );

function simulador_parcelamento_nextstream_update_simulacao_parcelas() {
    $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
    $variation = wc_get_product($variation_id);

    if ($variation) {
        $valor_produto = $variation->get_price();
        // Resto do código de simulação, usando $valor_produto
        echo simulador_parcelamento_nextstream_simulacao_parcelas($valor_produto); // A função que gera a simulação
    }

    wp_die();
}
add_action('wp_ajax_update_simulacao_parcelamento', 'simulador_parcelamento_nextstream_update_simulacao_parcelas');
add_action('wp_ajax_nopriv_update_simulacao_parcelamento', 'simulador_parcelamento_nextstream_update_simulacao_parcelas');


// Função para gerar a simulação de parcelamento
function simulador_parcelamento_nextstream_simulacao_parcelas($valor_produto = null)
{
	
    $product_id = get_the_ID();
    $product = wc_get_product($product_id);
	
    // Se $valor_produto não foi definido, obtenha o preço do produto
    if ($valor_produto === null) {
        // $valor_produto = get_post_meta(get_the_ID(), '_sale_price', true);

        // Verifica se o produto é variável
        if ($product->is_type('variable')) {
            // Obtém o preço mínimo e máximo para variações
            $valor_produto = $product->get_variation_price('min');
        } else {
            // Produto simples, pegue o preço de venda
            $valor_produto = get_post_meta($product_id, '_sale_price', true);
        }
    }
	
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
