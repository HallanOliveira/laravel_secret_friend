@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="row mb-3">
            <div class="col-md-12">
                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#create-secret-friend-group-modal"><i class="bi bi-plus-circle"></i> Novo Amigo Secreto</button>
            </div>
        </div>
        @if($errors->any())
            <div class="alert alert-danger temporary" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">{{ __('Meus amigos secretos') }}</div>
            <div class="card-body">
                @empty($secretFriendsGroups)
                    <div>Você ainda não possui nenhum amigo secreto.</div>
                @else
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data de revelação</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($secretFriendsGroups as $group)
                                <tr id="{{$group['id']}}">
                                    <td>{{$group['name']}}</td>
                                    <td>{{formatDate($group['reveal_date'])}}</td>
                                    <td class="float-right">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Ações</button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Alterar</a></li>
                                                <li><a class="dropdown-item" href="#">Deletar</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endempty
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
        <form id="create-secret-group-form" action="/secretFriendGroups" method="POST">
            <div class="mb-3">
                @csrf
                <label for="secret-group-name" class="form-label">Nome do grupo <span class="text-danger">*</span></label>
                <input type="text" maxlength="100" class="form-control required" name="name" id="secret-group-name" placeholder="Nome do grupo">
                <br>
                <label for="reveal-date" class="form-label">Data de revelação <span class="text-danger">*</span></label>
                <input type="date" maxlength="10" class="form-control" name="reveal_date" id="reveal-date">
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

@push('scripts')
@vite(['resources/js/home/script.js'])
@endpush
