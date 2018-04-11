# CPSMI Users Demo

## Usage

Clone the repository

```git clone https://github.com/tylergrinn/cpsmi-users-demo```

(Or download zip file)

Set relevant environment variables:

```SQL_LOCATION=<db-location>```
```SQL_USER=<db-username>```
```SQL_PASSWORD=<db-password>```
```SQL_DB_NAME=<db-name>```

Modify `USE 'TestDb'` in `init-db.sql` script to your db name.
Initialize MySql database:

```mysql -u <user> -p < init-db.sql```

Serve this directory using apache or nginx.

Direct browser to the served directory or make GET requests to "\<dir\>/api/users" with a "search" query paramater. eg: `GET localhost/api/users?search=Tyler`

## Troubleshooting

#### Apache
* Ensure pdo_myql is enabled: `sudo phpenmod pdo_mysql`
* Ensure env module enabled: `sudo a2enmod env`
* Set env vars in /etc/apache2/envvars (`export SQL_USR=root`) or in .htaccess (`SetEnv SQL_USER=root`)

#### NGINX
* Make sure all requests are redirected to index.php:
```
location / {
  try files $uri $uri/ /index.php$args;
}
```

