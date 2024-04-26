$('#participant-add').on('click', function() {
    const formOriginal = $('#form-participants');
    const form = $('#form-participants-example').clone().children()[0];
    if (formOriginal.children().length <= 5) {
        formOriginal.append(form);
    }
    return false;
});