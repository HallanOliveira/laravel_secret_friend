<?php

namespace App\Adapters\Providers;

use App\Core\Contracts\SortSecretFriendProvider;

class SortRadomic implements SortSecretFriendProvider
{
    /**
     * @param array $participants "array of DTOs"
     * @return array
     */
    public function execute(array $participants): array
    {
        $idsArr        = $this->getParticipantsIds($participants);
        $alreadySorted = [];
        $result        = [];

        foreach ($idsArr as $participantId) {
            do {
                $sort = rand(0, (count($participants) - 1));
            } while ($idsArr[$sort] === $participantId || in_array($sort, $alreadySorted));
            $alreadySorted[]        = $sort;
            $result[$participantId] = $idsArr[$sort];
        }
        return $result;
    }

    private function getParticipantsIds(array $participantsDTOs): array
    {
        $ids = [];
        foreach ($participantsDTOs as $participant) {
            $ids[] = $participant->id;
        }

        return $ids;
    }
}
