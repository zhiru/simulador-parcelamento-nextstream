<?php
// settings.php

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
            'Juros - Parcela ' . $i,
            'simulador_parcelamento_nextstream_juros_parcela_callback',
            'simulador_parcelamento_nextstream',
            'simulador_parcelamento_nextstream_section',
            array('parcela' => $i)
        );
    }

    add_settings_section(
        'simulador_parcelamento_nextstream_style_section',
        'Estilos do Simulador de Parcelamento',
        'simulador_parcelamento_nextstream_style_section_callback',
        'simulador_parcelamento_nextstream'
    );

    add_settings_field(
        'valor_parcelas_estilo',
        'Estilo do Valor das Parcelas',
        'simulador_parcelamento_nextstream_valor_parcelas_estilo_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_style_section'
    );

    add_settings_field(
        'texto_de_estilo',
        'Estilo do Texto "de"',
        'simulador_parcelamento_nextstream_texto_de_estilo_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_style_section'
    );

    add_settings_field(
        'texto_sem_juros_estilo',
        'Estilo do Texto "sem juros"',
        'simulador_parcelamento_nextstream_texto_sem_juros_estilo_callback',
        'simulador_parcelamento_nextstream',
        'simulador_parcelamento_nextstream_style_section'
    );

    register_setting('simulador_parcelamento_nextstream_settings', 'valor_minimo_parcela');
    for ($i = 1; $i <= 12; $i++) {
        register_setting('simulador_parcelamento_nextstream_settings', 'juros_parcela_' . $i);
    }

    register_setting('simulador_parcelamento_nextstream_settings', 'valor_parcelas_estilo');
    register_setting('simulador_parcelamento_nextstream_settings', 'texto_de_estilo');
    register_setting('simulador_parcelamento_nextstream_settings', 'texto_sem_juros_estilo');
}

function simulador_parcelamento_nextstream_section_callback() {
    echo '<p>Configure as opções de parcelamento:</p>';
}

function simulador_parcelamento_nextstream_valor_minimo_parcela_callback() {
    $valor_minimo_parcela = esc_attr(get_option('valor_minimo_parcela'));
    echo '<input type="number" step="0.01" min="0" name="valor_minimo_parcela" value="' . $valor_minimo_parcela . '" />';
}

function simulador_parcelamento_nextstream_juros_parcela_callback($args) {
    $parcela = $args['parcela'];
    $juros_parcela = esc_attr(get_option('juros_parcela_' . $parcela));
    echo '<input type="number" step="0.01" min="0" name="juros_parcela_' . $parcela . '" value="' . $juros_parcela . '" />';
}

function simulador_parcelamento_nextstream_style_section_callback() {
    echo '<p>Configure os estilos do simulador:</p>';
}

function simulador_parcelamento_nextstream_valor_parcelas_estilo_callback() {
    $valor_parcelas_estilo = esc_attr(get_option('valor_parcelas_estilo'));
    echo '<input type="text" name="valor_parcelas_estilo" value="' . $valor_parcelas_estilo . '" />';
}

function simulador_parcelamento_nextstream_texto_de_estilo_callback() {
    $texto_de_estilo = esc_attr(get_option('texto_de_estilo'));
    echo '<input type="text" name="texto_de_estilo" value="' . $texto_de_estilo . '" />';
}

function simulador_parcelamento_nextstream_texto_sem_juros_estilo_callback() {
    $texto_sem_juros_estilo = esc_attr(get_option('texto_sem_juros_estilo'));
    echo '<input type="text" name="texto_sem_juros_estilo" value="' . $texto_sem_juros_estilo . '" />';
}

add_action('admin_init', 'simulador_parcelamento_nextstream_settings_init');
