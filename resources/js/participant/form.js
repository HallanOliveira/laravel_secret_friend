window.removeOption = function(obj) {
    obj.closest('.participants-parent').remove();
    return false;
}

const formReference = '<div class="participants-parent">'
    + '     <span class="badge text-bg-secondary mb-3">Participante :key</span>'
    + '     <div class="row mb-3">'
    + '         <div class="col-md-4 d-flex">'
    + '             <input type="text" class="form-control" name="participants[:key][name]" placeholder="Nome">'
    + '         </div>'
    + '         <div class="col-4">'
    + '             <input type="text" class="form-control" name="participants[:key][email]" placeholder="Email">'
    + '         </div>'
    + '         <div class="col-3">'
    + '             <input type="text" class="form-control" onchange="$(this).mask(\'(00) 00000-0000\')" name="participants[:key][phone]" placeholder="Whatsapp">'
    + '         </div>'
    + '         <div class="col-1 d-flex justify-content-between">'
    + '             <a class="btn btn-danger btn-sm participant-remove" onclick="removeOption($(this))"><i class="bi bi-trash"></i></a>'
    + '         </div>'
    + '     </div>'
    + '</div>'

const addOption = function() {
    const formOriginal = $('#form-participants');
    const limit = 50;
    var lastKey = 0;
    if (formOriginal.children().length > 0) {
        lastKey = formOriginal
            .children()
            .last()
            .find('input')
            .attr('name')
            .replace('participants[', '')
            .replace('][nome]', '') || 0;
    }

    const nextKey = parseInt(lastKey) + 1;
    const formReferenceToAppend = formReference.replaceAll(':key', nextKey)
    if (formOriginal.children().length <= limit) {
        formOriginal.append(formReferenceToAppend);
        return false;
    }
    toastr.error(`O limite é de ${limit} participantes por grupo`)
    return false;
}

// Events listeners
$('#participant-add').on('click', function() {
    addOption();
});
