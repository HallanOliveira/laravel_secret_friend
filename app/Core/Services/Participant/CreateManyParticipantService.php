<?php

namespace App\Core\Services\Participant;

use App\Core\Contracts\Service;
use App\Core\Contracts\Repository;
use App\Core\Contracts\DTO;

class CreateManyParticipantService implements Service
{
    public function __construct(
        protected readonly array      $participantsDTOs,
        protected readonly Repository $participantRepository,
        protected readonly DTO        $secretFriendGroupDTO
    ) {
    }

    /**
     * Create many participants
     *
     * @return array
     * @throws \Exception
     */
    public function execute(): array
    {
        if (empty($this->participantsDTOs) || empty($this->secretFriendGroupDTO)) {
            throw new \Exception('Dados inválidos.');
        }

        $ownerId                = $this->secretFriendGroupDTO->owner_id;
        $secret_friend_group_id = $this->secretFriendGroupDTO->id;
        foreach($this->participantsDTOs as $participantDTO) {
            $participantArray                           = $participantDTO->toArray();
            $participantArray['secret_friend_group_id'] = $secret_friend_group_id;
            $participantArray['owner_id']               = $ownerId;
            $participantsArray[]                        = $participantArray;
        }

        $participantCreated = $this->participantRepository::createMany($participantsArray);
        return $participantCreated;
    }
}
