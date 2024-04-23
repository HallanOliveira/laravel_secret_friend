import axios from "axios";
import Swal from 'sweetalert2'

function createSecretGroup() {
    axios.post('/secretFriendGroups', {
        name: document.querySelector('#secret-group-name').value,
        reveal_date: document.querySelector('#reveal-date').value,
    })
    .then(function (response) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Secret group created successfully',
        })
    })
    .catch(function (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while creating secret group',
        })
    });
}

/**
 * Events listeners
 */
document
.querySelector('#save-secret-friend-group-form')
.addEventListener('click', function(){
    createSecretGroup();
});