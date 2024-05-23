<?php

namespace App\Core\Services\SecretFriendGroup;

use App\Core\Contracts\EmailProvider;
use App\Core\Contracts\Repository;
use App\Core\Contracts\Service;
use App\Core\Contracts\SortSecretFriendProvider;
use App\Core\DTO\SecretFriendGroupDTO;
use App\Core\Enums\SecretFriendStatusEnum;
use App\Mail\SecretFriendSortEmail;

class SortSecretFriendGroupService implements Service
{
    public function __construct(
        protected SecretFriendGroupDTO     $secretFriendGroupDTO,
        protected SortSecretFriendProvider $sortSecretFriendProvider,
        protected Repository               $participantRepository,
        protected Repository               $secretFriendGroupRepository
    ) {
    }

    /**
     * Execute the service
     *
     * @return array
     * @throws \Exception
     */
    public function execute()
    {
        $this->validateParticipants();
        $participants = $this->secretFriendGroupDTO->participants;
        $result       = $this->sortSecretFriendProvider->execute($participants);
        if (! $this->validateResult($result)) {
            throw new \Exception('Ocorreu um erro ao sortear o amigo secreto, por favor tente novamente.');
        }

        $participantUpdateds = [];
        foreach($participants as $participant) {
            $secretFriendId        = $result[$participant->id]['id'];
            $participantUpdateds[] = $this->participantRepository->update($participant->id, [
                'secret_friend_id' => $secretFriendId
            ]);
        }

        $this->secretFriendGroupRepository->update($this->secretFriendGroupDTO->id, [
            'status_id' => SecretFriendStatusEnum::Sorteado->value
        ]);

        $this->sendResultByEmail($participantUpdateds, $result);

        return $participantUpdateds;
    }

    /**
     * Validate the participants of the secret friend group
     *
     * @return void
     * @throws \Exception
     */
    public function validateParticipants()
    {
        if (! isset($this->secretFriendGroupDTO->participants)) {
            throw new \Exception('Amigo secreto não possui participantes para realizar o sorteio.');
        }

        if (count($this->secretFriendGroupDTO->participants) < 2) {
            throw new \Exception('Amigo secreto não possui participantes suficientes para realizar o sorteio.');
        }

        foreach($this->secretFriendGroupDTO->participants as $participant) {
            if (empty($participant->email)) {
                throw new \Exception('Um ou mais participantes não possuem email.');
            }
        }
    }

    /**
     * Validate the result of the secret friend
     *
     * @param array $result
     * @return bool
     */
    public function validateResult(array $result): bool
    {
        $participantsIds = [];
        foreach ($this->secretFriendGroupDTO->participants as $participant) {
            $participantsIds[] = $participant->id;
        }

        foreach ($result as $participantId => $secretFriend) {
            if (
                ! in_array($participantId, $participantsIds)
                || ! in_array($secretFriend['id'], $participantsIds)
                || $participantId === $secretFriend['id']
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * Send email to participants with the result of the secret friend draw
     *
     * @param array $participants
     * @param array $result
     * @return void
     * @throws \Exception
     */
    public function sendResultByEmail($participants, $result)
    {
        if (empty($participants)) {
            throw new \Exception('Não foi possível enviar o email, pois não foram encontrados os participantes do grupo.');
        }

        foreach ($participants as $participant) {
            $emailProvider = app(EmailProvider::class, [
                'mailable' => app(SecretFriendSortEmail::class)
            ]);
            $emailResponse = $emailProvider
                ->with((object)[
                    'group_name'         => $this->secretFriendGroupDTO->name,
                    'participant_name'   => $participant['name'],
                    'secret_friend_name' => $result[$participant['id']]['name'],
                    'reveal_date'        => formatDate($this->secretFriendGroupDTO->reveal_date),
                    'reveal_location'    => $this->secretFriendGroupDTO->reveal_location
                ])
                ->send($participant['email'], 'Amigo Secreto Sorteado');
            if (! $emailResponse) {
                throw new \Exception('Ocorreu um erro ao enviar o email para o participante ' . $participant['name']);
            }
        }
    }
}
