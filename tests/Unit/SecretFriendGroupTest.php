<?php

namespace Tests\Unit;

use App\Core\Contracts\DTO;
use Tests\TestCase;
use App\Models\SecretFriendGroup;
use App\Models\User;
use App\Core\Contracts\Repository;
use App\Repositories\SecretFriendGroupRepository;
use App\Core\DTO\SecretFriendGroup\InputSecretFriendGroupDTO;
use App\Core\DTO\SecretFriendGroup\OutputSecretFriendGroupDTO;
use App\Core\DTO\User\OutputUserDTO;
use App\Core\Services\SecretFriendGroup\CreateSecretFriendGroupService;
use App\Core\Services\SecretFriendGroup\UpdateSecretFriendGroupService;

class SecretFriendGroupTest extends TestCase
{
    protected readonly Repository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $model            = app(SecretFriendGroup::class);
        $this->repository = new SecretFriendGroupRepository($model);
        User::factory()->count(10)->create();
    }

    /**
     * @test
     */
    public function create_test()
    {
        try {
            $data    = SecretFriendGroup::factory()->make();
            $dto     = InputSecretFriendGroupDTO::create($data->attributesToArray());
            $service = new CreateSecretFriendGroupService($dto, $this->repository);
            $service->execute();
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertTrue(true);
    }

    /**
     * @test
     *
     * @depends create_test
     */
    public function update_test()
    {
        try {
            $random  = SecretFriendGroup::all()->first();
            $dto     = InputSecretFriendGroupDTO::create($random->toArray());
            $service = new UpdateSecretFriendGroupService($dto,$this->repository);
            $dto     = $service->execute();
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertTrue($dto instanceof DTO);
    }

    /**
     * @test
     *
     * @depends create_test
     */
    public function view_test()
    {
        try {
            $random                         = SecretFriendGroup::all()->first();
            $userDTO                        = OutputUserDTO::create($random->owner->toArray());
            $dataSecretFriendGroup          = $random->toArray();
            $dataSecretFriendGroup['owner'] = $userDTO;
            $secretFriendGroupDTO           = OutputSecretFriendGroupDTO::create($dataSecretFriendGroup);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertInstanceOf(OutputSecretFriendGroupDTO::class, $secretFriendGroupDTO);
    }

    /**
     * @test
     *
     * @depends create_test
     */
    public function delete_test()
    {
        try {
            $random = SecretFriendGroup::all()->first();
            $return = $this->repository->delete($random->id);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertTrue($return);
    }
}
