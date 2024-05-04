<?php

namespace App\Core\Services\SecretFriendGroup;

use App\Core\Contracts\Service;
use App\Core\Contracts\Repository;
use App\Core\Contracts\DTO;
use App\Core\Contracts\DBTransaction;
use App\Core\DTO\SecretFriendGroupDTO;
use App\Core\Services\Participant\CreateManyParticipantService;

class UpdateSecretFriendGroupService implements Service
{
    protected array $currentParticipants = [];

    public function __construct(
        protected DTO                          $dto,
        protected Repository                   $secretFriendRepository,
        protected Repository                   $participantRepository,
        protected DBTransaction                $DBTransaction
    ) {
        $this->currentParticipants = $this->getCurrentParticipants();
    }

    public function execute(): SecretFriendGroupDTO
    {
        $this->DBTransaction::begin();
        $data                     = $this->dto->toArray();
        $secretFriendGroupUpdated = $this->secretFriendRepository->update($data['id'], $data);
        if (empty($secretFriendGroupUpdated)) {
            $this->DBTransaction::rollBack();
            throw new \Exception('Erro ao atualizar grupo de amigo secreto.');
        }

        $participantesUpdateds = $this->participantSync($data['participants'], $secretFriendGroupUpdated);
        if (in_array(false,$participantesUpdateds)) {
            throw new \Exception('Erro ao criar participante.');
        }
        $secretFriendGroupCreated['participants'] = $participantesUpdateds;

        $this->DBTransaction::commit();
        return SecretFriendGroupDTO::create($secretFriendGroupUpdated);
    }

    private function participantSync(array $data, array $secretFriendGroupUpdated)
    {
        if (! empty($this->currentParticipants)) {
            $participantIds = array_keys($this->currentParticipants);
            foreach ($participantIds as $participantId) {
                $participantDeleted = $this->participantRepository->delete($participantId);
                if (! $participantDeleted) {
                    $this->DBTransaction::rollBack();
                    throw new \Exception('Erro ao atualizar participantes.');
                }
            }
        }

        if (empty($data)) {
            return [];
        }

        $createManyParticipantService = new CreateManyParticipantService(
            $data,
            $this->participantRepository,
            SecretFriendGroupDTO::create($secretFriendGroupUpdated)
        );
        return $createManyParticipantService->execute();
    }

    private function getCurrentParticipants()
    {
        $participantsToReturn = [];
        $participants         = $this->participantRepository->getAll(['secret_friend_group_id' => $this->dto->id]);
        if (! empty($participants)) {
            foreach($participants as $participant) {
                $participantsToReturn[$participant['id']] = $participant;
            }
        }
        return $participantsToReturn;
    }
}
