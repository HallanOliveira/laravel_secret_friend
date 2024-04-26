import Swal from 'sweetalert2';

$('#delete-group').on('click', function() {
    var groupId = $(this).data('id');
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, deletar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            axios({
                method: 'POST',
                url: '/secretFriendGroups/' + groupId,
                data: {_method: 'DELETE'}
            }).then(function(response) {
                window.location.href = '/secretFriendGroups';
            }).catch(function(error) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Ocorreu um erro ao deletar o grupo!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            })
        }
    })
});