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
        $alreadySorted = [];
        $result        = [];
        foreach ($participants as $participant) {
            do {
                $sort = rand(1, (count($participants)));
            } while ($participants[$sort]->id === $participant->id || in_array($sort, $alreadySorted));
            $alreadySorted[] = $sort;
            $result[$participant->id] = [
                'id'   => $participants[$sort]->id,
                'name' => $participants[$sort]->name
            ];
        }
        return $result;
    }
}
