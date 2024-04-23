@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row mb-3">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#create-secret-friend-group-modal"><i class="bi bi-plus-circle"></i> Novo Amigo Secreto</button>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Meus amigos secretos') }}</div>
                <div class="card-body">
                @if (! empty($secretFriends))
                    <div class="list-group">
                        @foreach ($secretFriends as $secretFriend)
                            <a href="#" class="list-group-item list-group-item-action">{{$secretFriend}}</a>
                        @endforeach
                    </div>
                @else
                    <div>Você ainda não possui nenhum amigo secreto.</div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="create-secret-friend-group-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Novo grupo de Amigo Secreto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form >
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nome do grupo</label>
                <input type="text" maxlength="100" class="form-control" id="secret-group-name" placeholder="Nome do grupo de amigo secreto">
                <br>
                <label for="exampleFormControlInput1" class="form-label">Data de revelação</label>
                <input type="date" maxlength="10" class="form-control" id="reveal-date" placeholder="Nome do grupo de amigo secreto">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="save-secret-friend-group-form">Salvar</button>
      </div>
    </div>
  </div>
</div>
@endsection
