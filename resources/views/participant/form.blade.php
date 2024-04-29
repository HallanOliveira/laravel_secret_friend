<div id="form-participants">
    @isset($participants)
        @foreach($participants as $key => $participant)
            <div class="participants-parent">
                <span class="badge text-bg-secondary mb-3">Participante {{$key}}</span>
                <div class="row mb-3">
                    <div class="col-md-4 d-flex">
                        <input type="text" {{$toView ? 'readonly="readonly"' : ''}} class="form-control" name="Participant[{{$key}}][name]" placeholder="Nome" value="{{old("Participant.$key.name", $participant['name'])}}">
                    </div>
                    <div class="col-4">
                        <input type="text" {{$toView ? 'readonly="readonly"' : ''}} class="form-control" name="Participant[{{$key}}][email]" placeholder="Email" value="{{old("Participant.$key.email", $participant['email'])}}">
                    </div>
                    <div class="col-3">
                        <input type="text" {{$toView ? 'readonly="readonly"' : ''}} class="form-control" name="Participant[{{$key}}][phone]" placeholder="Whatsapp" value="{{old("Participant.$key.phone", $participant['phone'])}}">
                    </div>
                    <div class="col-1 d-flex justify-content-between">
                        @if ($key > 0 && ! $toView)
                            <a class="btn btn-danger btn-sm participant-remove" onclick="removeOption($(this))"><i class="bi bi-trash"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
