import Swal from 'sweetalert2'

function createSecretGroup() {
    // if (validateForm()) {
        $('#create-secret-group-form').submit();
        return;
    // }

    Swal.fire({
        icon: 'warning',
        title: 'Atenção!',
        text: 'Preencha todos os campos obrigatórios!',
    })
    return false;
}

function validateForm() {
    const name = document.querySelector('#secret-group-name').value;
    const revealDate = document.querySelector('#reveal-date').value;

    if (name === '' || revealDate === '') {
        return false;
    }

    return true;

}

/**
 * Events listeners
 */
document
.querySelector('#save-secret-friend-group-form')
.addEventListener('click', function(){
    createSecretGroup();
});