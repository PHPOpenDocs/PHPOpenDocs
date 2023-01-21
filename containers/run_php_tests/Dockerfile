FROM debian:10

USER root

# Get Debian up-to-date
RUN apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y git \
    mariadb-client wget curl \
    ca-certificates lsb-release apt-transport-https gnupg bsdmainutils

# Install 3rd party PHP 8.2 packages
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee -a /etc/apt/sources.list.d/php.list
RUN curl -L https://packages.sury.org/php/apt.gpg | apt-key add -

RUN  apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y php8.2 php8.2-common php8.2-cli php8.2-fpm \
    php8.2-mysql  php8.2-curl php8.2-xml php8.2-mbstring \
    php8.2-intl php8.2-xdebug php8.2-zip php8.2-redis

# Make the default directory you
WORKDIR /var/app

ADD entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]