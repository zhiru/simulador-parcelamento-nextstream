jQuery(document).ready(function($) {
    // Quando a variação é selecionada
    $('.single_variation_wrap').on('show_variation', function(event, variation) {
        // Obtenha o ID da variação
        var variation_id = variation.variation_id;

        // Faça uma chamada AJAX para atualizar a simulação
        $.ajax({
            url: simulador_params.ajax_url,
            type: 'POST',
            data: {
                action: 'update_simulacao_parcelamento',
                variation_id: variation_id
            },
            success: function(response) {
                // Substitua o conteúdo da simulação
                $('.simulador-parcelamento').replaceWith(response);
            }
        });
    });
});
