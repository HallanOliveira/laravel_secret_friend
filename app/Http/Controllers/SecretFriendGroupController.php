<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\SecretFriendGroup;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\SecretFriendGroup\CreateSecretFriendRequest;
use App\Http\Requests\SecretFriendGroup\UpdateSecretFriendRequest;
use App\Repositories\SecretFriendGroupRepository;
use App\Repositories\ParticipantRepository;
use App\Core\Services\SecretFriendGroup\CreateSecretFriendGroupService;
use App\Core\Services\SecretFriendGroup\UpdateSecretFriendGroupService;
use App\Core\Services\SecretFriendGroup\ListSecretFriendGroupService;
use App\Core\DTO\SecretFriendGroup\InputSecretFriendGroupDTO;
use App\Core\DTO\SecretFriendGroup\OutputSecretFriendGroupDTO;
use App\Core\DTO\User\UserDTO;
use App\Core\DTO\Participant\ParticipantDTO;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SecretFriendGroupController extends AppBaseController
{
    public function __construct(
        protected readonly SecretFriendGroupRepository $secretFriendGroupRepository,
        protected readonly ParticipantRepository       $participantRepository,
    ) {
    }

    public function index(Request $request): ?View
    {
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

    public function store(CreateSecretFriendRequest $request): RedirectResponse
    {
        try {
            $payload          = $request->validated();
            $participantsDTOs = array_map(function($participant) {
                return ParticipantDTO::create( array_filter($participant));
            }, $payload['Participant'] ?? []);

            $payload['participants'] = $participantsDTOs;
            $secretFriendGroupDTO    = InputSecretFriendGroupDTO::create($payload);
            $service                 = new CreateSecretFriendGroupService(
                $secretFriendGroupDTO,
                $this->secretFriendGroupRepository,
                $this->participantRepository,
                auth()->id()
            );
            $service->execute();
        } catch (Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
        return $this->redirectWithSuccess('Grupo criado com sucesso!', 'secretFriendGroups.index');
    }

    public function show(SecretFriendGroup $secretFriendGroup): View|RedirectResponse
    {
        try {
            $dataSecretFriendGroup          = $secretFriendGroup->toArray();
            $userDTO                        = UserDTO::create($secretFriendGroup->owner->toArray());
            $dataSecretFriendGroup['owner'] = $userDTO;
            $secretFriendGroupDTO           = OutputSecretFriendGroupDTO::create($dataSecretFriendGroup);
            if (! empty($secretFriendGroup->participants)) {
                $participants = $secretFriendGroup->participants->toArray();
            }

            return view('secretFriendGroup.show', [
                'secretFriendGroup' => $secretFriendGroupDTO,
                'participants'      => $participants ?? [],
            ]);
        } catch (Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }

    }

    public function update(UpdateSecretFriendRequest $request, SecretFriendGroup $secretFriendGroup): RedirectResponse
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

    public function destroy(SecretFriendGroup $secretFriendGroup): void
    {
        try {
            $this->secretFriendGroupRepository->delete($secretFriendGroup->id);
        } catch (Exception $e) {
            $this->setFlashMessage($e->getMessage(), 'danger');
        }
        $this->setFlashMessage('Grupo deletado com sucesso!', 'success');
    }

    public function formCreate(): RedirectResponse|View
    {
        try {
            return view('secretFriendGroup.form', [
                'secretFriendGroup' => OutputSecretFriendGroupDTO::create([]),
                'isUpdate'          => false
            ]);
        } catch (Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
    }

    public function formUpdate(SecretFriendGroup $secretFriendGroup): RedirectResponse|View
    {
        try {
            $participantsDTO = array_map(function($participant) {
                return ParticipantDTO::create($participant->toArray());
            }, $secretFriendGroup->participants ?? []);

            $secretFriendGroupArray                 = $secretFriendGroup->toArray();
            $secretFriendGroupArray['participants'] = $participantsDTO;
            $secretFriendGroupDTO                   = OutputSecretFriendGroupDTO::create($secretFriendGroupArray);
            return view('secretFriendGroup.form', [
                'secretFriendGroup' => $secretFriendGroupDTO,
                'isUpdate'          => true
            ]);
        } catch (Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
    }
}
