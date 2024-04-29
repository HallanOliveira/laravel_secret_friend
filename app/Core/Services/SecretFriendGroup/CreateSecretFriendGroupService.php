<?php

namespace App\Core\Services\SecretFriendGroup;

use App\Core\Contracts\Service;
use App\Core\Contracts\Repository;
use App\Core\Contracts\DTO;
use App\Core\DTO\SecretFriendGroup\OutputSecretFriendGroupDTO;
use Illuminate\Support\Facades\DB;

class CreateSecretFriendGroupService implements Service
{
    public function __construct(
        protected DTO        $dto,
        protected Repository $secretFriendRepository,
        protected Repository $participantRepository,
        protected int        $ownerId
    ) {
    }

    public function execute(): OutputSecretFriendGroupDTO
    {
        $secretFriendGroupArray             = $this->dto->toArray();
        $secretFriendGroupArray['owner_id'] = $this->ownerId;

        DB::beginTransaction();

        $secretFriendGroupCreated = $this->secretFriendRepository->create($secretFriendGroupArray);
        if (empty($secretFriendGroupCreated['id'])) {
            throw new \Exception('Erro ao criar grupo de amigo secreto.');
        }

        $participantCreateds = [];
        if (! empty($secretFriendGroupArray['participants'])) {
            foreach($secretFriendGroupArray['participants'] as $participantDTO) {
                $participantArray                           = $participantDTO->toArray();
                $participantArray['secret_friend_group_id'] = $secretFriendGroupCreated['id'];
                $participantArray['owner_id']               = $this->ownerId;
                $participantsArray[]                        = $participantArray;
            }

            $participantCreated = $this->participantRepository::createMany($participantsArray);
            if (in_array(false,$participantCreated)) {
                DB::rollBack();
                throw new \Exception('Erro ao criar participante.');
            }
            $participantCreateds[] = $participantCreated;
            unset($participantCreated);
        }
        DB::commit();
        $secretFriendGroupCreated['participants'] = $participantCreateds;
        return OutputSecretFriendGroupDTO::create($secretFriendGroupCreated);
    }
}