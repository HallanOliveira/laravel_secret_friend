<table class="table table-hover">
    <thead>
        <tr>
            <th style="width: 40%">Nome</th>
            <th style="width: 40%">Data de revelação</th>
            <th style="width: 19%">status</th>
            <th style="width: 1%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($secretFriendsGroups as $group)
            <tr>
                <td >{{$group['name']}}</td>
                <td>{{formatDate($group['reveal_date'])}}</td>
                <td>
                    @switch($group['status_id'])
                        @case(1)
                            <span class="badge bg-warning">Pendente</span>
                            @break
                        @case(2)
                            <span class="badge bg-secondary">Processando</span>
                            @break
                        @case(3)
                            <span class="badge bg-success">Concluído</span>
                            @break
                        @default
                            <span class="badge bg-danger">Erro</span>
                    @endswitch
                </td>
                <td class="float-right">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Ações
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/secretFriendGroups/{{$group['id']}}" id="view-group">Visualizar</a></li>
                            @if ($group['status_id'] !== 3)
                                <li><a class="dropdown-item" href="/secretFriendGroups/{{$group['id']}}/formUpdate" id="update-group">Alterar</a></li>
                                @if (! empty($group["participants"]) && count($group["participants"]) > 1)
                                    <li><a class="dropdown-item sort-secret-friend" href="#" data-id="{{$group['id']}}">Sortear Amigo Secreto</a></li>
                                @endif
                            @endif
                            <li><a class="dropdown-item delete-group" href="#" data-id="{{$group['id']}}">Excluir</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
