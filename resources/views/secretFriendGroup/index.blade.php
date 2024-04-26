@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
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
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div class="h6">Meus amigos secretos</div>
                    <a type="button" class="btn btn-success float-end" href="/secretFriendGroups/formCreate" id="create-group">
                        <i class="bi bi-plus-circle"></i> Novo Amigo Secreto
                    </a>
                </div>
            </div>
            <div class="card-body">
                @empty($secretFriendsGroups)
                    <div>Você ainda não possui nenhum amigo secreto.</div>
                @else
                   @include('secretFriendGroup/table_groups', ['secretFriendsGroups' => $secretFriendsGroups])
                @endempty
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/secretFriendGroup/delete.js'])
@endpush
