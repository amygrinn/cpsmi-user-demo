# CPSMI Users Demo

## Installation

Clone the repository

```git clone https://github.com/tylergrinn/cpsmi-users-demo```

Set relevant environment variables:

```setx SQL_LOCATION <db-location>```
```setx SQL_USER <db-username>```
```setx SQL_PASSWORD <db-password>```
```setx SQL_DB_NAME <db-name>```

Serve this folder, redirect all requests that don't match a file to index.php eg: (NGINX)

```
location / {
  try files $uri $uri/ /index.php$args;
}
```

Initialize MySql database:

```mysql -u <user> -p < init-db.sql```

Direct browser to localhost or make GET requests to "/api/users" with a "search" query paramater. EG: `GET /api/users?search=Tyler`
