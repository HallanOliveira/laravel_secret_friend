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
            <tr>
                <td >{{$group['name']}}</td>
                <td>{{formatDate($group['reveal_date'])}}</td>
                <td class="float-right">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Ações
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/secretFriendGroups/{{$group['id']}}" id="view-group">Visualizar</a></li>
                            <li><a class="dropdown-item" href="/secretFriendGroups/{{$group['id']}}/formUpdate" id="update-group">Alterar</a></li>
                            <li><a class="dropdown-item" href="#" data-id="{{$group['id']}}" id="delete-group">Deletar</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>