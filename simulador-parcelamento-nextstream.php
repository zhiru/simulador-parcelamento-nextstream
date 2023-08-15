<?php
/*
Plugin Name: Simulador de Parcelamento Nextstream
Description: Plugin para adicionar funcionalidade de parcelamento personalizado ao WooCommerce.
Version: 1.2.7
Author: Sylas Filho
Author URI: https://nextstream.com.br
*/

define('SPNEXT_DIR', plugin_dir_path(__FILE__));

// Função para incluir os arquivos necessários
function simulador_parcelamento_nextstream_include_files() {
    include_once SPNEXT_DIR . 'includes/admin/admin.php';
    include_once SPNEXT_DIR . 'includes/frontend/frontend.php';
}
add_action('plugins_loaded', 'simulador_parcelamento_nextstream_include_files');
