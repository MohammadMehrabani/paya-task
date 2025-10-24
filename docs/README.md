# Paya Challenge

## setup steps

### 1. installation

```bash
git clone git@github.com:MohammadMehrabani/paya-task.git 
cd paya-task
cp .env.example .env
docker compose up -d --build web
docker compose exec php composer install
docker compose exec php php artisan key:generate
```

#### update variables in `.env` (optional)

```dotenv
DOCKER_DB_PORT=
DOCKER_APP_PORT=

MINIMUM_WITHDRAWABLE_BALANCE=
DAILY_WITHDRAWAL_LIMIT=
MINIMUM_TRANSFER_AMOUNT=
```

### 2. migrate tables

```bash
docker compose exec php php artisan migrate
docker compose exec php php artisan db:seed
```

## information for test

You can quickly test the application using the pre-seeded `admin` with `id = 1` and `account` with `id = f809dba0-b0d5-11f0-bfc9-822df4a1815c`.

## webservice usage

### list all requests

```bash
curl --location --request GET 'http://localhost:80/api/sheba'
```

### create paya transfer request

```bash
curl --location 'localhost:80/api/sheba' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data '{
    "account_id": "f809dba0-b0d5-11f0-bfc9-822df4a1815c",
    "from_sheba_number": "IR000000000000000000001234",
    "to_sheba_number": "IR000000000000000000005670",
    "price": 1000000,
    "note": "مدیریت نقدینگی"
}'
```

### update paya transfer request

`status 3 = canceled`
`status 2 = confirmed`

```bash
curl --location --request PUT 'localhost:80/api/sheba/{request-id}' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data '{
    "status": 3,
    "note": "به دلایل دیگر",
    "admin_id": 1
}'
```
