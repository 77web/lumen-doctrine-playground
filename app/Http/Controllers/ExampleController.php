<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Repositories\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\Request;
use Laravel\Socialite\SocialiteManager;
use Laravel\Socialite\Two\User;

class ExampleController extends Controller
{
    /**
     * @var SocialiteManager
     */
    private $socialiteManager;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ExampleController constructor.
     * @param SocialiteManager $socialiteManager
     * @param CustomerRepository $customerRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(SocialiteManager $socialiteManager, CustomerRepository $customerRepository, EntityManagerInterface $em)
    {
        $this->socialiteManager = $socialiteManager;
        $this->customerRepository = $customerRepository;
        $this->em = $em;
    }

    public function index(Request $request): RedirectResponse
    {
        return $this->socialiteManager->driver('google')->stateless()->redirect();
    }

    public function callback(): Response
    {
        /** @var User $user */
        $user = $this->socialiteManager->driver('google')->stateless()->user();

        $customer = $this->customerRepository->findOneBy(['googleId' => $user->getId()]);
        if (!$customer) {
            $customer = new Customer();
            $customer->setGoogleId($user->getId());
        }
        $customer->setName($user->getName());

        $this->em->persist($customer);
        $this->em->flush();

        return new Response('success');
    }
}
