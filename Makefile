MYSQL_CONTAINER_NAME = hicaliber-test-mysql

APP_PHP_CONTAINER_NAME = hicaliber-test-php
APP_NGINX_CONTAINER_NAME = hicaliber-test-nginx

DB_NAME = hicaliber-test_db
MYSQL_USER = root
MYSQL_PASS = root

EXEC_MYSQL = docker exec -it $(MYSQL_CONTAINER_NAME) bash

EXEC_APP_PHP = docker exec -it $(APP_PHP_CONTAINER_NAME) bash
EXEC_APP_NGINX = docker exec -it $(APP_NGINX_CONTAINER_NAME) bash

mysql_container:
	$(EXEC_MYSQL)

php_container:
	$(EXEC_APP_PHP)

nginx_container:
	$(EXEC_APP_NGINX)