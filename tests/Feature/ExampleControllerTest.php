<?php

namespace Tests\Feature;

use App\Entities\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Tests\TestCase;

class ExampleControllerTest extends TestCase
{
    public function test()
    {
        $app = $this->createApplication();

        $this->get('/example-save');
        $this->assertEquals(200, $this->response->getStatusCode());

        $customer = $app->get(EntityManagerInterface::class)->find(Customer::class, 1);
        $this->assertNotNull($customer);
    }
}
