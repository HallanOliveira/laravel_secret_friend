/**
 * Events listeners
 */
$('#save-secret-friend-group-form').on('click',() =>{
    $('#create-secret-group-form').submit();
});

$('#create-group-button').on('click', () => {
    axios.get('/secretFriendGroups/create').then((response) => {
        $('#modal-1').modal('toggle');
        console.log(response);

    });
});