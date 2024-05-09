@vite(['resources/js/app.js','resources/sass/app.scss'])
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Amigo Secreto: {{$group_name}}</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Olá {{$participant_name}}!</p>
                        <p class="card-text">Seu amigo secreto é: <b>{{$secret_friend_name}}</b>.</p>
                        <p class="card-text">A revelação deste amigo secreto ocorrerá dia <b>{{$reveal_date}}</b>, no local <b>{{$reveal_location}}</b>.</p>
                    </div>
                    <div class="card-footer">
                        <i class="card-text text-center" style="font-size: 8pt"><i class="bi bi-c-circle"></i> <b>Secret Friend App</b> - Desenvolvido por hallan_douglas@hotmail.com</i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
