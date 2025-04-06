# laravel-api-task-2025


## How to launch the project
* cp .env.example .env
* make composer-install
* make start
* make generate-app-key
* make recreate-db
* make run-db-migrations-with-seed


## How to run automated tests
* make run-tests


## How to check API manually
* make recreate-db
* make run-db-migrations-with-seed

```
curl --request GET \
--url 'http://localhost:8000/api/campaigns' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json'
```

```
curl --request GET \
  --url http://localhost:8000/api/campaigns/1 \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json'
```

```
curl --request POST \
  --url http://localhost:8000/api/investments \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --data '{"amount_fils": 1000,"campaign_id": 1}'
```


## How to check Pay-dividends command
* `make recreate-db`
* `make run-db-migrations-with-seed`
* create some investments for campaign_id=1
* `make shell`
* `php artisan app:pay-dividends --campaign_id=1 --amount=500` inside the shell


## Notes about Models
* Field `percentage_raised`.  
I'm not sure what it's exactly.  
I made a guess how it works.  
For the sake of simplicity, I made it as an integer, not a fractional number.  
Thus it's not accurate enough (could be a lot of `0` with small amount invested, it's not okay).  
Using `floor()` also is not okay.  

* Amount fields are in fils  
`The United Arab Emirates dirham (AED) is the currency of the United Arab Emirates. One dirham is divided into 100 fils.`  
So 1 AED is 100 fils.

* Field `image_url`.  
For the sake of simplicity, it's a static URL.


## Notes about API
* For the sake of simplicity, there is no API versioning, everything is under `/api/`
* We send/receive amounts to/from Clients in fils. It can be changed to more suitable output (for example to `321.51`).  


## Notes about Tests
For the sake of simplicity, there are minimum tests.  
More tests must be added.


## Notes about Pay-dividends-command
* Now it writes output as a .csv file. You can redirect output to any .csv file, that's it.
* We can improve the command, and for example add a `mode`, how to display the data, for example `json`, etc.
* Currently, this command **DO NOT** handle all edge cases correctly.  
It's a time-consuming process to write the logic to handle all cases.  
Also business requirements must be discussed at first.  
For example:  
\- what will happen if amount to be distributed is too small (0.01 AED)  
\- when the amount from the investment is too small, the paid amount may be 0  
\- etc.

* Input argument `amount` is considered as fractional number. For example 1.00 or 0.51.  
For the sake of simplicity, it's not validated fully (for example, there is no check for 2 decimal digits max)


## Notes about Mathematics operations
When we are dealing with mathematical operations, rounding, etc. we must use extension `bcmath` and its functions https://www.php.net/manual/en/book.bc.php  
For example https://www.php.net/manual/en/function.bcdiv.php etc.  
For the sake of simplicity, this extension was skipped.  
Stop using `floatval()`, `floor()` in the code, rewrite.

