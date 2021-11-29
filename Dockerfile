FROM debian:buster-slim as base
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

RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg &&\
    sh -c 'echo "deb https://packages.sury.org/php/ buster main" > /etc/apt/sources.list.d/php.list' &&\
    apt-get update && \
    apt-get --yes install \
        php7.4-cli \
        php7.4-opcache \
        php7.4-xml \
        php7.4-curl \
        php7.4-mbstring \
        php7.4-bcmath \
        php7.4-apcu \
        php7.4-zip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure PHP CLI
COPY docker/jmleroux.ini /etc/php/7.4/mods-available/jmleroux.ini
RUN phpenmod jmleroux

FROM base as dev

RUN apt-get update && \
    apt-get --yes install \
        php7.4-xdebug && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer
