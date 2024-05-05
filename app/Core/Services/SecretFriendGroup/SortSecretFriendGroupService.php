<?php

namespace App\Core\Services\SecretFriendGroup;

use App\Core\Contracts\Repository;
use App\Core\Contracts\Service;
use App\Core\Contracts\SortSecretFriendProvider;
use App\Core\DTO\SecretFriendGroupDTO;
use App\Core\Enums\SecretFriendStatusEnum;

class SortSecretFriendGroupService implements Service
{
    public function __construct(
        protected SecretFriendGroupDTO     $secretFriendGroupDTO,
        protected SortSecretFriendProvider $sortSecretFriendProvider,
        protected Repository               $participantRepository,
        protected Repository               $secretFriendGroupRepository,
    ) {
    }

    public function execute()
    {
        if (! isset($this->secretFriendGroupDTO->participants)) {
            throw new \Exception('Amigo secreto não possui participantes para realizar o sorteio.');
        }

        if (count($this->secretFriendGroupDTO->participants) < 2) {
            throw new \Exception('Amigo secreto não possui participantes suficientes para realizar o sorteio.');
        }

        $participants = $this->secretFriendGroupDTO->participants;
        $result       = $this->sortSecretFriendProvider->execute($participants);
        if (! $this->validateResult($result)) {
            throw new \Exception('Ocorreu um erro ao sortear o amigo secreto, por favor tente novamente.');
        }

        $participantUpdateds = [];
        foreach($participants as $participant) {
            $secretFriendId        = $result[$participant->id];
            $participantUpdateds[] = $this->participantRepository->update($participant->id, [
                'secret_friend_id' => $secretFriendId
            ]);
        }

        $this->secretFriendGroupRepository->update($this->secretFriendGroupDTO->id, [
            'status_id' => SecretFriendStatusEnum::Sorteado->value
        ]);

        return $participantUpdateds;
    }

    public function validateResult(array $result): bool
    {
        $participantsIds = [];
        foreach ($this->secretFriendGroupDTO->participants as $participant) {
            $participantsIds[] = $participant->id;
        }

        foreach ($result as $participantId => $secretFriendId) {
            if (
                ! in_array($participantId, $participantsIds)
                || ! in_array($secretFriendId, $participantsIds)
                || $participantId === $secretFriendId
            ) {
                return false;
            }
        }

        return true;
    }

}
