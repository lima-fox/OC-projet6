# OC Projet 6 - snowtricks

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/8f554dd65a9f4fd992a4b50434c1617d)](https://app.codacy.com/gh/lima-fox/OC-projet6?utm_source=github.com&utm_medium=referral&utm_content=lima-fox/OC-projet6&utm_campaign=Badge_Grade_Settings)


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




