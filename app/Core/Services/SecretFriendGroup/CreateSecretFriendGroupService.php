<?php

namespace App\Core\Services\SecretFriendGroup;

use App\Core\Contracts\Service;
use App\Core\Contracts\Repository;
use App\Core\Contracts\DTO;
use App\Core\Contracts\DBTransactionProvider;
use App\Core\DTO\SecretFriendGroupDTO;
use App\Core\Services\Participant\CreateManyParticipantService;
use App\Core\Enums\SecretFriendStatusEnum;

class CreateSecretFriendGroupService implements Service
{
    public function __construct(
        protected DTO                   $dto,
        protected Repository            $secretFriendRepository,
        protected Repository            $participantRepository,
        protected DBTransactionProvider $DBTransaction,
        protected int                   $ownerId
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

        $secretFriendGroupArray              = $this->dto->toArray();
        $secretFriendGroupArray['owner_id']  = $this->ownerId;
        $secretFriendGroupArray['status_id'] = SecretFriendStatusEnum::Pendente->value;

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
