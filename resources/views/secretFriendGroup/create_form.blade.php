<form id="create-secret-group-form" action="/secretFriendGroups" method="POST">
    <div class="mb-3">
        @csrf
        <label for="secret-group-name" class="form-label">Nome do grupo <span class="text-danger">*</span></label>
        <input type="text" maxlength="100" class="form-control required" name="name" id="secret-group-name" placeholder="Nome do grupo">
        <br>
        <label for="reveal-date" class="form-label">Data de revelação <span class="text-danger">*</span></label>
        <input type="date" maxlength="10" class="form-control" name="reveal_date" id="reveal-date">
    </div>
</form>