install:
	docker rm -f tmp_install || true
	docker-compose -f docker-compose.install.yml run -d --rm --no-deps --name tmp_install php
	docker cp tmp_install:/src ./laravel
	docker stop tmp_install
