# Bank Client

Simple client to make transactions with card.

##Installation:
1. Clone the repo.
2. Copy `.env.example` to `.env` file and provide your configurations there. IMPORTANT: provide this `BANK_SERVER_BASE_URI=localhost:8001` - the host for the Bank Server.
3. Create db:
```shell
touch storage/database/bank_client.db
```
4. Run migrations.

## Usage:
There two routes:
- `transaction` - you can see the list of all transactions;
- `transaction/create` - you can create new transaction.

There there users in the darabase already:
1. User 1:
	- 'first_name' => 'John'
	- 'last_name' => 'Dow'
	- Card:
		* 'card_number' => '1234 1234 1234 1234'
		* 'card_expiration' => '07/16'
		* 'balance' => 100
2. User 2:
	- 'first_name' => 'Jane'
	- 'last_name' => 'Dow'
	- Card:
		* 'card_number' => '1235 1235 1235 1235'
		* 'card_expiration' => '07/16'
		* 'balance' => 90,
3. User 3:
	- 'first_name' => 'Jack'
	- 'last_name' => 'Doe'
	- Card:
		* 'card_number' => '1236 1236 1236 1236'
		* 'card_expiration' => '07/16'
		* 'balance' => 120

## Misc
There was an attemt to implement [Clean Architecture](https://blog.8thlight.com/uncle-bob/2012/08/13/the-clean-architecture.html). The vital parts of aplication are unit tested.
