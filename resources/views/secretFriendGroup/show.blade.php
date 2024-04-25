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
                Amigo Secreto #{{$secretFriendGroup->id}}
            </div>
            <div class="card-body">
                @foreach ($secretFriendGroup->toArray() as $key => $value)
                    @if($key == 'reveal_date' || $key == 'created_at')
                        <div class="mb-3">
                            <label for="{{$key}}" class="form-label">{{__('validation.attributes.'.$key)}}</label>
                            <input type="date" class="form-control"  readonly="readonly" name="{{$key}}" id="{{$key}}" value="{{formatDate($value, 'Y-m-d')}}">
                        </div>
                    @else
                        <div class="mb-3">
                            <label for="{{$key}}" class="form-label">{{__('validation.attributes.'.$key)}}</label>
                            <input type="text" class="form-control" readonly="readonly" name="{{$key}}" id="{{$key}}" value="{{$key == 'owner' ? nameAndNickname($secretFriendGroup->owner->name) : $value}}">
                        </div>
                    @endif
                @endforeach
                <div class="float-end">
                    <a class="btn btn-secondary" href="/secretFriendGroups">Voltar</a>
                    <a class="btn btn-primary" href="/secretFriendGroups/{{$secretFriendGroup->id}}/formUpdate">Alterar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection