<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use BankClient\Domain\Entity\Transaction;
use BankClient\Domain\Entity\User;
use BankClient\Domain\Entity\Card;
use BankClient\Domain\Service\BillingService;
use BankClient\Domain\Contract\HttpBankClientInterface;

use BankClient\Persistence\Laravel\Hydrator\HydratorInterface;
use BankClient\Domain\Repository\TransactionRepositoryInterface;

class TransactionController extends Controller
{
    protected $hydrator;
    protected $repository;
    protected $httpClient;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        HydratorInterface $hydrator,
        TransactionRepositoryInterface $repository,
        HttpBankClientInterface $httpClient
    ){
        $this->middleware('menu');

        $this->hydrator = $hydrator;
        $this->repository = $repository;
        $this->httpClient = $httpClient;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $transactions = $this->repository->getAll();

        return view('transaction.index')->with(compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('transaction.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            "first_name" => "required",
            "last_name" => "required",
            "card_number" => "required|card_number",
            "card_expiration" => "required|card_expiration",
            "amount" => "required|numeric|min:1",
        ];

        $this->validate($request, $rules);

        $user = $this->hydrator->hydrate(new User, $request);
        $card = $this->hydrator->hydrate(new Card, $request);
        $transaction = $this->hydrator->hydrate(new Transaction, $request);

        $this->httpClient->setUser($user);
        $this->httpClient->setCard($card);

        $billingService = new BillingService(
            $this->httpClient,
            $transaction,
            $this->repository
        );

        $billingService->conductTransaction();

        dd($billingService);

        //dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }
}
