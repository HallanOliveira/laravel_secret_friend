$('#moda-1').on('hidden.bs.modal', function (e) {
    $(this).find('form').trigger('reset');
});