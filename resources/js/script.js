$(function() {
    setTimeout(function() {
        $('.temporary').fadeOut('slow');
    }, 5000);
});

window.populateAndOpenModal = function (content, title, modal = '#modal-1') {
    $(modal + ' > .modal-dialog > .modal-content > .modal-body').html(content);
    $(modal + ' > .modal-dialog > .modal-content > .modal-header > #modal-title').html(title);
    $(modal).modal('show');
}