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
                @if($isUpdate)
                    Alterar Amigo Secreto
                @else
                    Criar amigos secretos
                @endif
            </div>
            <div class="card-body">
                <form id="secret-group-form" action="/secretFriendGroups{{$isUpdate ? '/' . $secretFriendGroup->id : ''}}" method="POST">
                    <div class="mb-3">
                        @csrf
                        @if ($isUpdate)
                            <input type="hidden" name="_method" value="put" />
                        @endif
                        <label for="secret-group-name" class="form-label">Nome do grupo <span class="text-danger">*</span></label>
                        <input type="text" maxlength="100" class="form-control required" name="name" id="secret-group-name" placeholder="Nome do grupo" value="{{$isUpdate ? old('name', $secretFriendGroup->name) : old('name')}}">
                        <br>
                        <label for="reveal-date" class="form-label">Data de revelação <span class="text-danger">*</span></label>
                        <input type="date" maxlength="10" class="form-control" name="reveal_date" id="reveal-date"  value="{{formatDate($isUpdate ? old('reveal_date', $secretFriendGroup->reveal_date) : old('reveal_date',''), 'Y-m-d')}}">
                        <hr>
                        <div class="h6 col-3">Participantes:</div>
                        @include('participant.form', [
                            'participants' => $secretFriendGroup->participants ?? old('Participant'),
                            'readonly'     => false
                        ])
                        <a class="btn btn-success btn-sm" id="participant-add"><i class="bi bi-plus-square"></i> Adicionar Participates</a>
                        <hr>
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

@push('scripts')
@vite(['resources/js/participant/form.js'])
@endpush