<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SecretFriendGroup;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\SecretFriendGroup\CreateSecretFriendRequest;
use App\Http\Requests\SecretFriendGroup\UpdateSecretFriendRequest;
use App\Repositories\SecretFriendGroupRepository;
use App\Repositories\ParticipantRepository;
use App\Core\Services\SecretFriendGroup\CreateSecretFriendGroupService;
use App\Core\Services\SecretFriendGroup\UpdateSecretFriendGroupService;
use App\Core\Services\SecretFriendGroup\ListSecretFriendGroupService;
use App\Core\Services\SecretFriendGroup\DeleteSecretFriendGroupService;
use App\Core\Services\SecretFriendGroup\SortSecretFriendGroupService;
use App\Core\DTO\SecretFriendGroupDTO;
use App\Core\DTO\UserDTO;
use App\Core\DTO\ParticipantDTO;
use App\Adapters\Providers\EmailLaravel;
use App\Adapters\Providers\DBTransactionLaravel;
use App\Adapters\Providers\SortRadomic;
use App\Mail\SecretFriendSortEmail;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Core\Enums\SecretFriendStatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SecretFriendGroupController extends AppBaseController
{
    public function __construct(
        protected readonly SecretFriendGroupRepository $secretFriendGroupRepository,
        protected readonly ParticipantRepository       $participantRepository,
        protected readonly DBTransactionLaravel        $DBTransaction
    ) {
    }

    /**
     * Lista secret friend groups
     *
     * @param Request $request
     * @return View|null
     */
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

    /**
     * Create secret friend group and participants
     *
     * @param CreateSecretFriendRequest $request
     * @return RedirectResponse
     */
    public function store(CreateSecretFriendRequest $request): RedirectResponse
    {
        try {
            $payload          = $request->validated();
            $participantsDTOs = array_map(function($participant) {
                return ParticipantDTO::create( array_filter($participant));
            }, $payload['participants'] ?? []);

            $payload['participants'] = $participantsDTOs;
            $secretFriendGroupDTO    = SecretFriendGroupDTO::create($payload);
            $service                 = new CreateSecretFriendGroupService(
                $secretFriendGroupDTO,
                $this->secretFriendGroupRepository,
                $this->participantRepository,
                $this->DBTransaction,
                auth()->id()
            );
            $service->execute();
        } catch (Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
        return $this->redirectWithSuccess('Grupo criado com sucesso!', 'secretFriendGroups.index');
    }

    /**
     * Show secret friend resume
     *
     * @param SecretFriendGroup $secretFriendGroup
     * @return View|RedirectResponse
     */
    public function show(SecretFriendGroup $secretFriendGroup): View|RedirectResponse
    {
        try {
            $dataSecretFriendGroup          = $secretFriendGroup->toArray();
            $userDTO                        = UserDTO::create($secretFriendGroup->owner->toArray());
            $dataSecretFriendGroup['owner'] = $userDTO;
            $i = 1;
            if (! empty($secretFriendGroup->participants)) {
                $participantsArray = $secretFriendGroup->participants->toArray();
                foreach($participantsArray as $participant) {
                    $participantsDTOs[$i++] = ParticipantDTO::create(array_filter($participant));
                }
            }
            $secretFriendGroupDTO['participants'] = $participantsDTOs ?? [];
            $secretFriendGroupDTO = SecretFriendGroupDTO::create($dataSecretFriendGroup);

            return view('secretFriendGroup.show', [
                'secretFriendGroup' => $secretFriendGroupDTO,
                'participants'      => $participantsDTOs ?? [],
            ]);
        } catch (Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }

    }

    /**
     * Update secret friend
     *
     * @param UpdateSecretFriendRequest $request
     * @param SecretFriendGroup $secretFriendGroup
     * @return RedirectResponse
     */
    public function update(UpdateSecretFriendRequest $request, SecretFriendGroup $secretFriendGroup): RedirectResponse
    {
        try {
            $payload          = $request->validated();
            $payload['id']    = $secretFriendGroup->id;
            $dataDTO          = $payload;
            $participantsDTOs = [];
            $i                = 1;

            if (! empty($payload['participants'])) {
                foreach($payload['participants'] as $participant) {
                    $participantsDTOs[$i++] = ParticipantDTO::create(array_filter($participant));
                }
            }

            $dataDTO['participants'] = $participantsDTOs;
            $secretFriendGroupDTO    = SecretFriendGroupDTO::create($dataDTO);
            $service                 = new UpdateSecretFriendGroupService(
                $secretFriendGroupDTO,
                $this->secretFriendGroupRepository,
                $this->participantRepository,
                $this->DBTransaction
            );
            $service->execute();
        } catch(Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
        return $this->redirectWithSuccess('Grupo atualizado com sucesso!', 'secretFriendGroups.index');
    }

    /**
     * Delete secre friend group
     *
     * @param SecretFriendGroup $secretFriendGroup
     * @return void
     */
    public function destroy(SecretFriendGroup $secretFriendGroup): void
    {
        try {
            $service = new DeleteSecretFriendGroupService(
                $secretFriendGroup->id,
                $this->DBTransaction,
                $this->secretFriendGroupRepository,
                $this->participantRepository
            );
            $service->execute();
        } catch (Exception $e) {
            $this->setFlashMessage($e->getMessage(), 'danger');
        }
        $this->setFlashMessage('Grupo deletado com sucesso!', 'success');
    }

    /**
     * Get create html form
     *
     * @return RedirectResponse|View
     */
    public function formCreate(): RedirectResponse|View
    {
        try {
            return view('secretFriendGroup.form', [
                'secretFriendGroup' => [],
                'isUpdate'          => false
            ]);
        } catch (Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
    }

    /**
     * Get update html form
     *
     * @param SecretFriendGroup $secretFriendGroup
     * @return RedirectResponse|View
     */
    public function formUpdate(SecretFriendGroup $secretFriendGroup): RedirectResponse|View
    {
        try {
            if ($secretFriendGroup->status_id === SecretFriendStatusEnum::Sorteado->value) {
                throw new Exception('Não é possível editar um grupo de amigo secreto já sorteado.');
            }

            $participantsDTOs = [];
            $i = 1;
            if (! empty($secretFriendGroup->participants)) {
                $participantsArray = $secretFriendGroup->participants->toArray();
                foreach($participantsArray as $participant) {
                    $participantsDTOs[$i++] = ParticipantDTO::create(array_filter($participant));
                }
            }

            $secretFriendGroupArray                 = $secretFriendGroup->toArray();
            $secretFriendGroupArray['participants'] = $participantsDTOs;
            $secretFriendGroupDTO                   = SecretFriendGroupDTO::create($secretFriendGroupArray);
            return view('secretFriendGroup.form', [
                'secretFriendGroup' => $secretFriendGroupDTO,
                'isUpdate'          => true
            ]);
        } catch (Exception $e) {
            return $this->redirectWithError($e->getMessage(), 'secretFriendGroups.index');
        }
    }

    /**
     * Sort secret friend group
     *
     * @param SecretFriendGroup $secretFriendGroup
     * @return JsonResponse
     */
    public function sort(SecretFriendGroup $secretFriendGroup): JsonResponse
    {
        try {
            DB::beginTransaction();
            $participantsDTOs = [];
            $i = 1;
            if (! empty($secretFriendGroup->participants)) {
                $participantsArray = $secretFriendGroup->participants->toArray();
                foreach($participantsArray as $participant) {
                    $participantsDTOs[$i++] = ParticipantDTO::create(array_filter($participant));
                }
            }

            $secretFriendGroupArray                 = $secretFriendGroup->toArray();
            $secretFriendGroupArray['participants'] = $participantsDTOs;
            $secretFriendGroupDTO                   = SecretFriendGroupDTO::create($secretFriendGroupArray);
            $sortService                            = new SortSecretFriendGroupService(
                $secretFriendGroupDTO,
                new SortRadomic,
                $this->participantRepository,
                $this->secretFriendGroupRepository
            );
            $sortService->execute();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(['message' => 'Sorteio realizado com sucesso! Cada participante recebeu um email com o seu amigo secreto!'], 200);
    }
}
