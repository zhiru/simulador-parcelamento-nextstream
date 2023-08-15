<?php
// admin.php

// Adiciona a página de configurações no painel do WordPress
function simulador_parcelamento_nextstream_settings_page() {
    add_options_page(
        'Configurações do Simulador de Parcelamento Nextstream',
        'Simulador Parcelamento',
        'manage_options',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_render_settings_page'
    );
}
add_action('admin_menu', 'simulador_parcelamento_nextstream_settings_page');

// Renderiza a página de configurações
function simulador_parcelamento_nextstream_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Configurações do Simulador de Parcelamento Nextstream</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('simulador_parcelamento_nextstream_settings');
            do_settings_sections('simulador_parcelamento_nextstream');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Callback para a seção de configurações de parcelamento
function simulador_parcelamento_nextstream_section_callback() {
    echo '<p>Configure as opções de parcelamento:</p>';
}

// Callback para o campo de valor mínimo de cada parcela
function simulador_parcelamento_nextstream_valor_minimo_parcela_callback() {
    $valor_minimo_parcela = esc_attr(get_option('valor_minimo_parcela'));
    echo '<input type="number" step="0.01" min="0" name="valor_minimo_parcela" value="' . $valor_minimo_parcela . '" />';
}

// Callback para os campos de juros de cada parcela
function simulador_parcelamento_nextstream_juros_parcela_callback($args) {
    $parcela = $args['parcela'];
    $juros_parcela = esc_attr(get_option('juros_parcela_' . $parcela));
    echo '<input type="number" step="0.01" min="0" name="juros_parcela_' . $parcela . '" value="' . $juros_parcela . '" />';
}

// Callback para a seção de configurações de estilo
function simulador_parcelamento_nextstream_section_style_callback() {
    echo '<p>Configuração de Estilo do Simulador:</p>';
}

// Callback para o campo de tamanho da fonte do número de parcelas
function simulador_parcelamento_nextstream_tamanho_fonte_parcelas_callback() {
    $tamanho_fonte_parcelas = esc_attr(get_option('tamanho_fonte_parcelas'));
    echo '<input type="text" name="tamanho_fonte_parcelas" value="' . $tamanho_fonte_parcelas . '" />';
}

// Callback para o campo de peso da fonte do número de parcelas
function simulador_parcelamento_nextstream_peso_fonte_parcelas_callback() {
    $peso_fonte_parcelas = esc_attr(get_option('peso_fonte_parcelas'));
    echo '<input type="text" name="peso_fonte_parcelas" value="' . $peso_fonte_parcelas . '" />';
}

// Callback para o campo de cor da fonte do número de parcelas
function simulador_parcelamento_nextstream_cor_fonte_parcelas_callback() {
    $cor_fonte_parcelas = esc_attr(get_option('cor_fonte_parcelas'));
    echo '<input type="color" name="cor_fonte_parcelas" value="' . $cor_fonte_parcelas . '" />';
}

// Callback para o campo de tamanho da fonte do texto
function simulador_parcelamento_nextstream_tamanho_fonte_texto_callback() {
    $tamanho_fonte_texto = esc_attr(get_option('tamanho_fonte_texto'));
    echo '<input type="text" name="tamanho_fonte_texto" value="' . $tamanho_fonte_texto . '" />';
}

// Callback para o campo de peso da fonte do texto
function simulador_parcelamento_nextstream_peso_fonte_texto_callback() {
    $peso_fonte_texto = esc_attr(get_option('peso_fonte_texto'));
    echo '<input type="text" name="peso_fonte_texto" value="' . $peso_fonte_texto . '" />';
}

// Callback para o campo de cor da fonte do texto
function simulador_parcelamento_nextstream_cor_fonte_texto_callback() {
    $cor_fonte_texto = esc_attr(get_option('cor_fonte_texto'));
    echo '<input type="color" name="cor_fonte_texto" value="' . $cor_fonte_texto . '" />';
}

// Callback para o campo de tamanho da fonte do valor das parcelas
function simulador_parcelamento_nextstream_tamanho_fonte_valor_parcelas_callback() {
    $tamanho_fonte_valor_parcelas = esc_attr(get_option('tamanho_fonte_valor_parcelas'));
    echo '<input type="text" name="tamanho_fonte_valor_parcelas" value="' . $tamanho_fonte_valor_parcelas . '" />';
}

// Callback para o campo de peso da fonte do valor das parcelas
function simulador_parcelamento_nextstream_peso_fonte_valor_parcelas_callback() {
    $peso_fonte_valor_parcelas = esc_attr(get_option('peso_fonte_valor_parcelas'));
    echo '<input type="text" name="peso_fonte_valor_parcelas" value="' . $peso_fonte_valor_parcelas . '" />';
}

// Callback para o campo de cor da fonte do valor das parcelas
function simulador_parcelamento_nextstream_cor_fonte_valor_parcelas_callback() {
    $cor_fonte_valor_parcelas = esc_attr(get_option('cor_fonte_valor_parcelas'));
    echo '<input type="color" name="cor_fonte_valor_parcelas" value="' . $cor_fonte_valor_parcelas . '" />';
}

// Cria os campos de configuração
function simulador_parcelamento_nextstream_settings_init() {
    add_settings_section(
        'simulador_parcelamento_nextstream_section',
        'Configurações de Parcelamento',
        'simulador_parcelamento_nextstream_section_callback',
        'simulador_parcelamento_nextstream'
    );

    add_settings_field(
        'valor_minimo_parcela',
        'Valor Mínimo de Cada Parcela',
        'simulador_parcelamento_nextstream_valor_minimo_parcela_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_section'
    );

    for ($i = 1; $i <= 12; $i++) {
        add_settings_field(
            'juros_parcela_' . $i,
            'Juros da Parcela ' . $i,
            'simulador_parcelamento_nextstream_juros_parcela_callback',
            'simulador_parcelamento_nextstream',
            'simulador_parcelamento_nextstream_section',
            ['parcela' => $i]
        );
    }

    add_settings_section(
        'simulador_parcelamento_nextstream_section_style',
        'Configuração de Estilo',
        'simulador_parcelamento_nextstream_section_style_callback',
        'simulador_parcelamento_nextstream'
    );

    add_settings_field(
        'tamanho_fonte_parcelas',
        'Tamanho da Fonte do Número de Parcelas',
        'simulador_parcelamento_nextstream_tamanho_fonte_parcelas_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_section_style'
    );

    add_settings_field(
        'peso_fonte_parcelas',
        'Peso da Fonte do Número de Parcelas',
        'simulador_parcelamento_nextstream_peso_fonte_parcelas_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_section_style'
    );

    add_settings_field(
        'cor_fonte_parcelas',
        'Cor da Fonte do Número de Parcelas',
        'simulador_parcelamento_nextstream_cor_fonte_parcelas_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_section_style'
    );

    add_settings_field(
        'tamanho_fonte_texto',
        'Tamanho da Fonte do Texto',
        'simulador_parcelamento_nextstream_tamanho_fonte_texto_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_section_style'
    );

    add_settings_field(
        'peso_fonte_texto',
        'Peso da Fonte do Texto',
        'simulador_parcelamento_nextstream_peso_fonte_texto_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_section_style'
    );

    add_settings_field(
        'cor_fonte_texto',
        'Cor da Fonte do Texto',
        'simulador_parcelamento_nextstream_cor_fonte_texto_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_section_style'
    );

    add_settings_field(
        'tamanho_fonte_valor_parcelas',
        'Tamanho da Fonte do Valor das Parcelas',
        'simulador_parcelamento_nextstream_tamanho_fonte_valor_parcelas_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_section_style'
    );

    add_settings_field(
        'peso_fonte_valor_parcelas',
        'Peso da Fonte do Valor das Parcelas',
        'simulador_parcelamento_nextstream_peso_fonte_valor_parcelas_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_section_style'
    );

    add_settings_field(
        'cor_fonte_valor_parcelas',
        'Cor da Fonte do Valor das Parcelas',
        'simulador_parcelamento_nextstream_cor_fonte_valor_parcelas_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_section_style'
    );

    register_setting('simulador_parcelamento_nextstream_settings', 'valor_minimo_parcela');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_1');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_2');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_3');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_4');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_5');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_6');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_7');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_8');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_9');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_10');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_11');
    register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_12');
    register_setting('simulador_parcelamento_nextstream_settings', 'tamanho_fonte_parcelas');
    register_setting('simulador_parcelamento_nextstream_settings', 'peso_fonte_parcelas');
    register_setting('simulador_parcelamento_nextstream_settings', 'cor_fonte_parcelas');
    register_setting('simulador_parcelamento_nextstream_settings', 'tamanho_fonte_texto');
    register_setting('simulador_parcelamento_nextstream_settings', 'peso_fonte_texto');
    register_setting('simulador_parcelamento_nextstream_settings', 'cor_fonte_texto');
    register_setting('simulador_parcelamento_nextstream_settings', 'tamanho_fonte_valor_parcelas');
    register_setting('simulador_parcelamento_nextstream_settings', 'peso_fonte_valor_parcelas');
    register_setting('simulador_parcelamento_nextstream_settings', 'cor_fonte_valor_parcelas');
}
add_action('admin_init', 'simulador_parcelamento_nextstream_settings_init');
