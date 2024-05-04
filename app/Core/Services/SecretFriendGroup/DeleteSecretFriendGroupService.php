<?php

namespace App\Core\Services\SecretFriendGroup;

use App\Core\Contracts\DBTransaction;
use App\Core\Contracts\Repository;

class DeleteSecretFriendGroupService
{
    public function __construct(
        protected readonly int            $id,
        protected readonly DBTransaction  $DBTransaction,
        protected readonly Repository     $secretFriendGroupRepository,
        protected readonly Repository     $participantRepository
    ) {
    }

    /**
     * Delete secret friend group and participants
     *
     * @return bool
     * @throws \Exception
     */
    public function execute(): bool
    {
        $this->DBTransaction::begin();

        $participants = $this->participantRepository->getAll(['secret_friend_group_id' => $this->id]);
        if (! empty($participants)) {
            foreach ($participants as $participant) {
                $participantDeleted = $this->participantRepository->delete($participant['id']);
                if (! $participantDeleted) {
                    $this->DBTransaction::rollBack();
                    throw new \Exception('Erro ao excluir participante.');
                }
            }
        }

        $secretFriendGroupDeleted = $this->secretFriendGroupRepository->delete($this->id);
        if (! $secretFriendGroupDeleted) {
            $this->DBTransaction::rollBack();
            throw new \Exception('Erro ao excluir amigo secreto não encontrado.');
        }

        $this->DBTransaction::commit();
        return true;
    }
}
