How to install:

1. composer install

2. php app/console doctrine:migrations:migrate

How to test:

1. php app/console doctrine:fixtures:load

2. php app/console student:generate:path

3. ./bin/phpunit -c app/

4. ./bin/phpcs --standard=PSR2 src/

---

[![Build Status](https://travis-ci.org/e-moe/high-load.svg)](https://travis-ci.org/e-moe/high-load)
