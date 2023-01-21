FROM debian:11

USER root

RUN apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y nginx \
    ca-certificates wget curl git \
    lsb-release apt-transport-https gnupg

# Install 3rd party PHP 8.2 packages
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee -a /etc/apt/sources.list.d/php.list

RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg

RUN  apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install --no-install-recommends -y php8.2 php8.2-common php8.2-cli php8.2-fpm \
    php8.2-mysql php8.2-curl php8.2-xml php8.2-mbstring \
    php8.2-intl php8.2-redis php8.2-zip

WORKDIR /var/app

CMD sh /var/app/containers/nginx/entrypoint.sh

# For debugging, rather than having the container exit immediately,
# being able to switch the command to be just 'follow that file' allows
# you to bash into the container to inspect the state after nginx has crashed.
# CMD ["tail", "-f", "/var/app/readme.MD"]