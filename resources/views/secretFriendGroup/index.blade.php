@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="row mb-3">
            <div class="col-md-12">
                <button type="button" class="btn btn-success float-end" id="create-group-button">
                    <i class="bi bi-plus-circle"></i> Novo Amigo Secreto
                </button>
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
                                <th style="width: 40%">Nome</th>
                                <th style="width: 40%">Data de revelação</th>
                                <th style="width: 1%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($secretFriendsGroups as $group)
                                <tr id="{{$group['id']}}">
                                    <td >{{$group['name']}}</td>
                                    <td>{{formatDate($group['reveal_date'])}}</td>
                                    <td class="float-right">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Ações
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" id="alter-group">Alterar</a></li>
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
@endsection

@push('scripts')
@vite(['resources/js/secretFriendGroup/script.js'])
@endpush
