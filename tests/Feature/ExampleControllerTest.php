<?php

namespace Tests\Feature;

use App\Entities\Customer;
use App\Repositories\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Tests\TestCase;

class ExampleControllerTest extends TestCase
{
    public function test()
    {
        $app = $this->createApplication();

        $this->get('/example-save');
        $this->assertEquals(200, $this->response->getStatusCode());

        $customers = $app->get(EntityManagerInterface::class)->getRepository(Customer::class)->findAll();
        $this->assertGreaterThanOrEqual(1, count($customers));

        $customers = $app->get(CustomerRepository::class)->findAll();
        $this->assertGreaterThanOrEqual(1, count($customers));
    }
}
