<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\Request;

class ExampleController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function index(Request $request): Response
    {
        $customer = new Customer();
        $customer
            ->setName('dummy')
            ->setGoogleId('dummy');

        $this->em->persist($customer);
        $this->em->flush();

        return new Response('success', 200);
    }
}
