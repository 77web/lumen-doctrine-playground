<?php

namespace Tests\Feature;

use App\Entities\Customer;
use App\Repositories\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Laravel\Socialite\SocialiteManager;
use Laravel\Socialite\Two\User;
use Tests\TestCase;

class ExampleControllerTest extends TestCase
{
    public function test()
    {
        $this->get('/');
        $this->assertEquals(302, $this->response->getStatusCode());
    }

    public function test_callback()
    {
        $socialiteMock = \Mockery::mock(SocialiteManager::class);
        $googleUser = new User();
        $googleUser->map([
            'name' => 'dummy-name',
            'id' => 'dummy-id',
        ]);
        $socialiteMock->shouldReceive('driver->stateless->user')->andReturn($googleUser)->once();
        $this->app[SocialiteManager::class] = $socialiteMock;

        $this->get('/google-callback');
        $this->assertEquals(200, $this->response->getStatusCode());

        $customer = $this->app->get(CustomerRepository::class)->findOneBy(['googleId' => 'dummy-id']);
        $this->assertNotNull($customer, 'dummy-idを持つCustomerが登録されていること');
    }
}
