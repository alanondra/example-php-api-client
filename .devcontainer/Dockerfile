FROM mcr.microsoft.com/devcontainers/base:bookworm

ARG PHP_VERSION=8.4.0
ARG OPENSSL_VERSION=3.4.0

# Install Tools
RUN apt update && \
    apt install -y --no-install-recommends \
        vim

# Install Libraries
RUN apt update && \
    apt install -y --no-install-recommends \
        build-essential \
        pkg-config \
        autoconf

# Configure Paths
ENV PKG_CONFIG_PATH="/usr/local/lib64/pkgconfig:${PKG_CONFIG_PATH}" \
    LD_LIBRARY_PATH="/usr/local/lib64:${LD_LIBRARY_PATH}" \
    LD_RUN_PATH=/usr/local/lib64

# Install OpenSSL
RUN mkdir -p /tmp/openssl && \
    cd /tmp/openssl && \
    git clone --branch "openssl-${OPENSSL_VERSION}" https://github.com/openssl/openssl.git . && \
    ./config \
        --prefix=/usr/local \
        --openssldir=/usr/local/etc/openssl \
        shared zlib \
    && \
    make -j"$(nproc)" && \
    make install_sw && \
    echo "/usr/local/lib64" > /etc/ld.so.conf.d/openssl.conf && \
    ldconfig

# Install PHP
RUN apt update && \
    apt install -y --no-install-recommends \
        bison \
        re2c \
        libargon2-dev \
        libonig-dev \
        libsodium-dev \
        libsqlite3-dev \
        libxml2-dev

RUN mkdir -p /tmp/php && \
    cd /tmp/php && \
    git clone --branch "php-${PHP_VERSION}" https://github.com/php/php-src.git . && \
    ./buildconf --force && \
    ./configure \
        --prefix=/usr/local \
        --bindir=/usr/local/bin \
        --sbindir=/usr/local/sbin \
        --libdir=/usr/local/lib64/php \
        --includedir=/usr/local/include/php \
        --mandir=/usr/share/man \
        --datadir=/usr/local/share/php \
        --sysconfdir=/usr/local/etc/php \
        --with-config-file-path=/usr/local/etc/php \
        --enable-debug \
        --enable-intl \
        --enable-mbstring \
        --enable-sockets \
        --with-curl \
        --with-openssl \
        --with-openssl-argon2 \
        --with-sodium \
        --with-password-argon2 \
        --with-zlib \
    && \
    make -j"$(nproc)" && \
    make install && \
    cp -n php.ini-* /usr/local/etc/php && \
    ln -sf /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini; \
    mkdir -p /usr/local/etc/php/conf.d && \
    php --version

ENV PHP_INI_SCAN_DIR=/usr/local/etc/php/conf.d

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin \
        --filename=composer && \
    composer --version

# Clean Up
RUN apt clean && \
    rm -rf /tmp/*
