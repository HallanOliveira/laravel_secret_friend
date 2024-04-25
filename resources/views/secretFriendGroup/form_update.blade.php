@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                Alterar Amigo Secreto
            </div>
            <div class="card-body">
                <form id="secret-group-form" action="/secretFriendGroups/{{$secretFriendGroup->id}}" method="POST">
                    <div class="mb-3">
                        @csrf
                        <input type="hidden" name="_method" value="put" />
                        <label for="secret-group-name" class="form-label">Nome do grupo <span class="text-danger">*</span></label>
                        <input type="text" maxlength="100" class="form-control required" name="name" id="secret-group-name" placeholder="Nome do grupo" value="{{old('name', $secretFriendGroup->name)}}">
                        <br>
                        <label for="reveal-date" class="form-label">Data de revelação <span class="text-danger">*</span></label>
                        <input type="date" maxlength="10" class="form-control" name="reveal_date" id="reveal-date" value="{{old('reveal_date', formatDate($secretFriendGroup->reveal_date, 'Y-m-d'))}}">
                    </div>
                    <div class="float-end">
                        <a type="button" class="btn btn-secondary" href="/secretFriendGroups">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection