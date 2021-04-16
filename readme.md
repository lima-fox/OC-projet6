# OC Projet 6 - snowtricks

### Install dependancies
```shell
composer install
```

### create and configure the app
```shell
cp .env.example .env
```

### run the migrations
```shell
php bin/console doctrine:migrations:migrate
 ```

### Sample data

To use sample data run the SQL file `/data/snowtricks.sql`

and copy the files `/data/img_trick` to `/public/img_trick`




