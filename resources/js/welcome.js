import axios from "axios";
import Swal from 'sweetalert2'

function execute() {
    window.location.href = '/login';
}

const buttonStart = document.querySelector('#start-welcome');
buttonStart.addEventListener('click', function(){
    execute();
});