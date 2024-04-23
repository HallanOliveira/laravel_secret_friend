<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Services\SecretFriendGroup\CreateSecretFriendGroupService;
use App\Core\DTO\SecretFriendGroup\CreateSecretFriendGroupDTO;
use App\Repositories\SecretFriendGroupRepository;
use App\Http\Requests\CreateSecretFriendRequest;

class SecretFriendGroupController extends Controller
{
    public function __construct(protected SecretFriendGroupRepository $repository)
    {
    }

    public function index() {
        return view('home', [
            'secretFriends' => [
                '10/12/2023: Revenda Mais',
                '25/12/2023: Familia Oliveira'
            ]
        ]);
    }

    public function store(CreateSecretFriendRequest $request)
    {
        try {
            $request->validated();
            $payload             = $request->validated();
            $payload['owner_id'] = auth()->id();
            $dto                 = new CreateSecretFriendGroupDTO($payload);
            $service             = new CreateSecretFriendGroupService($dto, $this->repository);
            $service->execute();
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return redirect()->route('secretFriendGroups.index');
    }

    public function show($id)
    {
        return false;
    }

    public function update($id)
    {
        return false;
    }

    public function destroy($id)
    {
        return false;
    }
}
