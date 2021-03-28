FROM debian:9


USER root

# Get Debian up-to-date
RUN apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y git \
    wget curl varnish libmaxminddb0 psmisc \
    ca-certificates lsb-release apt-transport-https gnupg bsdmainutils


RUN apt-key del B188E2B695BD4743
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg

RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee -a /etc/apt/sources.list.d/php.list

# RUN curl -L https://packages.sury.org/php/apt.gpg | apt-key add -




RUN  apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install --no-install-recommends -y \
    git php7.4 \
    php7.4-common php7.4-cli \
    php7.4-mysql php7.4-curl php7.4-xml php7.4-mbstring \
    php7.4-intl php7.4-redis php7.4-zip


# Make the default directory you sh into
WORKDIR /var/app

COPY lib/libvmod_geoip2.la /usr/lib/x86_64-linux-gnu/varnish/vmods/libvmod_geoip2.la
COPY lib/libvmod_geoip2.so /usr/lib/x86_64-linux-gnu/varnish/vmods/libvmod_geoip2.so

CMD sh /var/app/containers/varnish/entrypoint.sh
