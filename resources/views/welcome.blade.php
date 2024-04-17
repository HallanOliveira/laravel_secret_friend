@extends('layouts.app')
@section('content')

<div>
    <h4>Seja bem vindo(a) ao aplicativo de organizar amigo secreto!</h4>
    <br>
    <p><b>Aqui você poderá:</b></p>
    <ul class="list-group">
        <li class="list-group-item"><i class="bi bi-check-square-fill text-success"></i> Organizar um ou mais eventos de amigo secreto</li>
        <li class="list-group-item"><i class="bi bi-check-square-fill text-success"></i> Participar de um amigo secreto</li>
        <li class="list-group-item"><i class="bi bi-check-square-fill text-success"></i> Visualizar os amigos secretos que você está participando</li>
        <li class="list-group-item"><i class="bi bi-check-square-fill text-success"></i> Cadastrar participantes de um amigo secreto</li>
        <li class="list-group-item"><i class="bi bi-check-square-fill text-success"></i> Realizar sorteio de amigo secreto</li>
    </ul>
    <hr>
    <button type="button" class="btn btn-primary btn-lg" onclick="execute()">Começar</button>
</div>

@endsection