FROM debian:bullseye-slim as dev
MAINTAINER JM Leroux <jmleroux.pro@gmail.com>

ENV DEBIAN_FRONTEND noninteractive

RUN echo 'APT::Install-Recommends "0" ; APT::Install-Suggests "0" ;' > /etc/apt/apt.conf.d/01-no-recommended && \
    echo 'path-exclude=/usr/share/man/*' > /etc/dpkg/dpkg.cfg.d/path_exclusions && \
    echo 'path-exclude=/usr/share/doc/*' >> /etc/dpkg/dpkg.cfg.d/path_exclusions && \
    apt-get update && \
    apt-get --yes install \
        apt-transport-https \
        ca-certificates \
        curl \
        git \
        procps \
        unzip \
        wget

RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && sh -c 'echo "deb https://packages.sury.org/php/ bullseye main" > /etc/apt/sources.list.d/php.list' \
    && apt update \
    && apt --yes install \
        php8.1-cli \
        php8.1-opcache \
        php8.1-xml \
        php8.1-curl \
        php8.1-mbstring \
        php8.1-bcmath \
        php8.1-apcu \
        php8.1-zip \
        php8.1-xdebug \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure PHP CLI
COPY docker/jmleroux.ini /etc/php/8.1/mods-available/jmleroux.ini
RUN phpenmod jmleroux

RUN useradd docker --shell /bin/bash --create-home \
  && usermod --append --groups sudo docker \
  && echo 'ALL ALL = (ALL) NOPASSWD: ALL' >> /etc/sudoers \
  && echo 'docker:secret' | chpasswd

COPY --from=composer:2.4 /usr/bin/composer /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

USER docker
WORKDIR /home/docker/
