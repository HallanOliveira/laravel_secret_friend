<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Core\Services\SecretFriendGroup\CreateSecretFriendGroupService;
use App\Core\Services\SecretFriendGroup\ListSecretFriendGroupService;
use App\Core\DTO\SecretFriendGroup\InputSecretFriendGroupDTO;
use App\Repositories\SecretFriendGroupRepository;
use App\Http\Requests\CreateSecretFriendRequest;
use Exception;

class SecretFriendGroupController extends AppBaseController
{
    public function __construct(
        protected readonly SecretFriendGroupRepository $secretFriendGroupRepository
    ) {}

    public function index(Request $request) {
        try {
            $filters             = $request->all();
            $service             = new ListSecretFriendGroupService($filters, $this->secretFriendGroupRepository);
            $secretFriendsGroups = $service->execute();
        } catch (Exception $e) {
            $this->setFlashMessage($e->getMessage(), 'danger');
        }
        return view('secretFriendGroup/index', [
            'secretFriendsGroups' => $secretFriendsGroups ?? []
        ]);
    }

    public function store(CreateSecretFriendRequest $request)
    {
        try {
            $request->validated();
            $payload             = $request->validated();
            $payload['owner_id'] = auth()->id();
            $dto                 = InputSecretFriendGroupDTO::create($payload);
            $service             = new CreateSecretFriendGroupService($dto, $this->secretFriendGroupRepository);
            $service->execute();
        } catch (\Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
        return $this->redirectWithSuccess('Grupo criado com sucesso!', 'secretFriendGroups.index');
    }

    public function show($id)
    {
        return false;
    }

    public function update($id)
    {
        return false;
    }

    public function destroy($id)
    {
        return false;
    }

    public function create()
    {
        return view('secretFriendGroup/create_form');
    }
}
