FROM debian:9

USER root

RUN apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y nginx \
    ca-certificates wget curl git \
    lsb-release apt-transport-https gnupg

# Install 3rd party PHP 7.4 packages
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee -a /etc/apt/sources.list.d/php.list

RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg

RUN  apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install --no-install-recommends -y php7.4 php7.4-common php7.4-cli php7.4-fpm \
    php7.4-mysql php7.4-curl php7.4-xml php7.4-mbstring \
    php7.4-intl php7.4-redis php7.4-zip

WORKDIR /var/app

# CMD ["/usr/sbin/nginx", "-c", "/var/app/containers/nginx/config/nginx.conf"]
CMD sh /var/app/containers/nginx/entrypoint.sh

# For debugging, rather than having the container exit immediately,
# being able to switch the command to be just 'follow that file' allows
# you to bash into the container to inspect the state after nginx has crashed.
# CMD ["tail", "-f", "/var/app/readme.MD"]