<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\SecretFriendGroup;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\SecretFriendGroup\CreateSecretFriendRequest;
use App\Http\Requests\SecretFriendGroup\UpdateSecretFriendRequest;
use App\Repositories\SecretFriendGroupRepository;
use App\Core\Services\SecretFriendGroup\CreateSecretFriendGroupService;
use App\Core\Services\SecretFriendGroup\UpdateSecretFriendGroupService;
use App\Core\Services\SecretFriendGroup\ListSecretFriendGroupService;
use App\Core\DTO\SecretFriendGroup\InputSecretFriendGroupDTO;
use App\Core\DTO\SecretFriendGroup\OutputSecretFriendGroupDTO;
use App\Core\DTO\User\OutputUserDTO;

class SecretFriendGroupController extends AppBaseController
{
    public function __construct(
        protected readonly SecretFriendGroupRepository $secretFriendGroupRepository
    ) {
    }

    public function index(Request $request) {
        try {
            $filters             = $request->all();
            $service             = new ListSecretFriendGroupService($filters, $this->secretFriendGroupRepository);
            $secretFriendsGroups = $service->execute();
        } catch (Exception $e) {
            $this->setFlashMessage($e->getMessage(), 'danger');
        }
        return view('secretFriendGroup.index', [
            'secretFriendsGroups' => $secretFriendsGroups ?? []
        ]);
    }

    public function store(CreateSecretFriendRequest $request)
    {
        try {
            $payload               = $request->validated();
            $payload['owner_id']   = auth()->id();
            $payload['created_by'] = auth()->id();
            $dto                   = InputSecretFriendGroupDTO::create($payload);
            $service               = new CreateSecretFriendGroupService($dto, $this->secretFriendGroupRepository);
            $service->execute();
        } catch (\Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
        return $this->redirectWithSuccess('Grupo criado com sucesso!', 'secretFriendGroups.index');
    }

    public function show(SecretFriendGroup $secretFriendGroup)
    {
        try {
            $userDTO                        = OutputUserDTO::create($secretFriendGroup->owner->toArray());
            $dataSecretFriendGroup          = $secretFriendGroup->toArray();
            $dataSecretFriendGroup['owner'] = $userDTO;
            $secretFriendGroupDTO           = OutputSecretFriendGroupDTO::create($dataSecretFriendGroup);
            return view('secretFriendGroup.show', [
                'secretFriendGroup' => $secretFriendGroupDTO
            ]);
        } catch (Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }

    }

    public function update(UpdateSecretFriendRequest $request, SecretFriendGroup $secretFriendGroup)
    {
        try {
            $payload = $request->validated();
            $dto     = InputSecretFriendGroupDTO::create($payload + $secretFriendGroup->toArray());
            $service = new UpdateSecretFriendGroupService($dto, $this->secretFriendGroupRepository);
            $service->execute();
        } catch(Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
        return $this->redirectWithSuccess('Grupo atualizado com sucesso!', 'secretFriendGroups.index');
    }

    public function destroy(SecretFriendGroup $secretFriendGroup)
    {
        try {
            $this->secretFriendGroupRepository->delete($secretFriendGroup->id);
        } catch (Exception $e) {
            $this->setFlashMessage($e->getMessage(), 'danger');
        }
        $this->setFlashMessage('Grupo deletado com sucesso!', 'success');
    }

    public function formCreate()
    {
        try {
            return view('secretFriendGroup.form_create');
        } catch (Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
    }

    public function formUpdate(SecretFriendGroup $secretFriendGroup)
    {
        try {
            $dto = OutputSecretFriendGroupDTO::create($secretFriendGroup->toArray());
        } catch (Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
        return view('secretFriendGroup.form_update', [
            'secretFriendGroup' => $dto
        ]);
    }
}
