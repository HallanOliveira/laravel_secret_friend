$('.delete-group').on('click', function() {
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

$('.sort-secret-friend').on('click', function() {
    Swal.fire({
        title: 'Tem certeza?',
        html: "Deseja iniciar o sorteio deste amigo secreto?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Iniciar sorteio',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const groupId = $(this).data('id');
            axios({
                method: 'POST',
                url: '/secretFriendGroups/' + groupId + '/sort'
            }).then(function(response) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: response.data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = '/secretFriendGroups';
                });
            }).catch(function(error) {
                Swal.fire({
                    title: 'Erro!',
                    text: error.response.data.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            })
        }
    });
});
