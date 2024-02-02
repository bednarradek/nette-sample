phpcs:
	docker compose exec -it web /var/www/html/vendor/bin/phpcs --standard=/var/www/html/codesniffer.xml --extensions=php /var/www/html/app /var/www/html/www

phpcbf:
	docker compose exec -it web /var/www/html/vendor/bin/phpcbf --standard=/var/www/html/codesniffer.xml --extensions=php /var/www/html/app /var/www/html/www

phpstan:
	docker compose exec -it web /var/www/html/vendor/bin/phpstan analyse -l 6 /var/www/html/app /var/www/html/www