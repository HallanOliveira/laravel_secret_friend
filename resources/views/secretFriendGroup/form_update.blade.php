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
                        <hr>

                        <div class="h6 col-3">Participantes:</div>

                        <div id="form-participants">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="Participant[nome][]" placeholder="Nome">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="Participant[email][]" placeholder="Email">
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" name="Participant[whatsapp][]" placeholder="Whatsapp">
                                </div>
                                <div class="col-1 d-flex justify-content-between">
                                    <a class="btn btn-success btn-sm" id="participant-add"><i class="bi bi-plus-square"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="float-end">
                        <a type="button" class="btn btn-secondary" href="/secretFriendGroups">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="form-participants-example" style="display: none">
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" name="Participant[nome][]" placeholder="Nome">
        </div>
        <div class="col-4">
            <input type="text" class="form-control" name="Participant[email][]" placeholder="Email">
        </div>
        <div class="col-3">
            <input type="text" class="form-control" name="Participant[whatsapp][]" placeholder="Whatsapp">
        </div>
        <div class="col-1 d-flex justify-content-between">
            <a class="btn btn-danger btn-sm participant-remove" onclick="removeOption($(this))"><i class="bi bi-trash"></i></a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/participant/form-add.js', 'resources/js/participant/form-remove.js'])
@endpush