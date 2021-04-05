FROM phpopendocs_php_fpm:latest

RUN DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
  php7.4-xdebug valgrind strace

COPY xdebug.ini /etc/php/7.4/fpm/conf.d/20-xdebug.ini

COPY valgrind.sh /usr/local/sbin/valgrind
RUN chmod +x /usr/local/sbin/valgrind
