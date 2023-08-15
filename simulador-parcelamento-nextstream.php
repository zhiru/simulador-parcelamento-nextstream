<?php
/*
Plugin Name: Simulador de Parcelamento Nextstream
Description: Plugin para adicionar funcionalidade de parcelamento personalizado ao WooCommerce.
Version: 1.3.0
Author: Sylas Filho
Author URI: https://nextstream.com.br
*/
if (! defined('ABSPATH'))
{
    exit;
}


define('SPNEXT_PATH', plugin_dir_path(__FILE__));
define('SPNEXT_URL', plugin_dir_url(__FILE__));
define('SPNEXT_VERSION', '1.3.0');
define('SPNEXT_NAME', 'Simulador de Parcelamento Nextstream');
define('SPNEXT_SLUG', 'simulador-parcelamento-nextstream');

// Função para incluir os arquivos necessários
function simulador_parcelamento_nextstream_include_files() {
    include_once SPNEXT_PATH . 'includes/admin/admin.php';
    include_once SPNEXT_PATH . 'includes/frontend/frontend.php';
}
add_action('plugins_loaded', 'simulador_parcelamento_nextstream_include_files');
