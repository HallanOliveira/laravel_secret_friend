<div id="form-participants">
    @isset($participants)
        @foreach($participants as $key => $participant)
            <div class="participants-parent">
                <span class="badge text-bg-secondary mb-3">Participante {{$key}}</span>
                <div class="row mb-3">
                    <div class="col-md-4 d-flex">
                        <input type="text" {{$toView ? 'readonly="readonly"' : ''}} class="form-control" name="participants[{{$key}}][name]" placeholder="Nome" value="{{old("participants.$key.name", $participant->name ?? '')}}">
                    </div>
                    <div class="col-4">
                        <input type="text" {{$toView ? 'readonly="readonly"' : ''}} class="form-control" name="participants[{{$key}}][email]" placeholder="Email" value="{{old("participants.$key.email", $participant->email ?? '')}}">
                    </div>
                    <div class="col-3">
                        <input type="text" {{$toView ? 'readonly="readonly"' : ''}} class="form-control phone-mask" name="participants[{{$key}}][phone]" placeholder="Whatsapp" value="{{old("participants.$key.phone", $participant->phone ?? '')}}">
                    </div>
                    <div class="col-1 d-flex justify-content-between">
                        @if (! $toView)
                            <a class="btn btn-danger btn-sm participant-remove" onclick="removeOption($(this))"><i class="bi bi-trash"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
