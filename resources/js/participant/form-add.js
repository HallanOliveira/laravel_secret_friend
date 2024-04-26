$('#participant-add').on('click', function() {
    const formOriginal = $('#form-participants');
    const limit = 50;
    const form = $('#form-participants-example').clone().children()[0];
    if (formOriginal.children().length <= limit) {
        formOriginal.append(form);
        return false;
    }
    toastr.error(`O limite é de ${limit} participantes por grupo`)
    return false;
});