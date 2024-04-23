function start() {
    window.location.href = '/login';
}

const buttonStart = document.querySelector('#start-welcome');
buttonStart.addEventListener('click', function(){
    start();
});