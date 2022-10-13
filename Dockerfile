FROM php:8.0-apache

ENV WORKDIR=/var/www
ENV CERTS_DIR=$WORKDIR/certs
ENV PRIVATE_KEY_PATH=$CERTS_DIR/private_key.pem
ENV CERTIFICATE_PATH=$CERTS_DIR/certificate.crt

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG HOME_DIR=/home/www-data

RUN apt update

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN mkdir ${HOME_DIR} \
    && chown -R ${USER_ID}:${GROUP_ID} ${HOME_DIR} \
    && usermod --uid ${USER_ID} --home ${HOME_DIR} --shell /bin/bash www-data \
    && groupmod --gid ${GROUP_ID} www-data \
    && adduser www-data sudo \
    && adduser www-data adm \
    && echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

RUN apt install -y git

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php --version=1.10.21 && rm composer-setup.php && mv composer.phar /usr/local/bin/composer

COPY . ${WORKDIR}

COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN openssl req -newkey rsa:3072 -new -x509 -days 3652 -nodes -out ${CERTIFICATE_PATH} -keyout ${PRIVATE_KEY_PATH} -subj "/C=US/ST=Denial/L=Springfield/O=Dis/CN=www.example.com"

RUN a2enmod rewrite
RUN service apache2 restart

WORKDIR ${WORKDIR}

RUN chown www-data. ${WORKDIR}

USER www-data

RUN composer -n install --prefer-dist

USER root

EXPOSE 80