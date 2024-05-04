<?php

namespace App\Core\Services\SecretFriendGroup;

use App\Core\Contracts\Service;
use App\Core\Contracts\Repository;
use App\Core\Contracts\DTO;
use App\Core\Contracts\DBTransaction;
use App\Core\DTO\SecretFriendGroupDTO;
use App\Core\Services\Participant\CreateManyParticipantService;

class CreateSecretFriendGroupService implements Service
{
    public function __construct(
        protected DTO           $dto,
        protected Repository    $secretFriendRepository,
        protected Repository    $participantRepository,
        protected DBTransaction $DBTransaction,
        protected int           $ownerId
    ) {
    }

    /**
     * Create new secret friend group
     *
     * @return SecretFriendGroupDTO
     * @throws \Exception
     */
    public function execute(): SecretFriendGroupDTO
    {
        $this->DBTransaction::begin();

        $secretFriendGroupArray             = $this->dto->toArray();
        $secretFriendGroupArray['owner_id'] = $this->ownerId;

        $secretFriendGroupCreated = $this->secretFriendRepository->create($secretFriendGroupArray);
        if (empty($secretFriendGroupCreated['id'])) {
            throw new \Exception('Erro ao criar grupo de amigo secreto.');
        }

        $participantCreateds = [];
        if (! empty($secretFriendGroupArray['participants'])) {
            $createManyParticipantService = new CreateManyParticipantService(
                $secretFriendGroupArray['participants'],
                $this->participantRepository,
                SecretFriendGroupDTO::create($secretFriendGroupCreated)
            );
            $participantCreateds          = $createManyParticipantService->execute();
            if (in_array(false,$participantCreateds)) {
                throw new \Exception('Erro ao criar participante.');
            }
        }
        $this->DBTransaction::commit();
        $secretFriendGroupCreated['participants'] = $participantCreateds;
        return SecretFriendGroupDTO::create($secretFriendGroupCreated);
    }
}
