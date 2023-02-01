FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
		acl \
		fcgi \
		file \
		gettext \
		git \
		gnu-libiconv \
		npm \
		mysql-client \
	;

# install gnu-libiconv and set LD_PRELOAD env to make iconv work fully on Alpine image.
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so

RUN set -eux; \
	apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		icu-dev \
		libzip-dev \
		zlib-dev \
		libpq-dev \
		# gd dependency
		libpng-dev \ 
	; \
	\
	docker-php-ext-configure zip; \
	docker-php-ext-install -j$(nproc) \
		intl \
		zip \
		gd \
        pdo_mysql \
	; \
	pecl install \
		apcu-5.1.21 \
	; \
	docker-php-ext-enable \
		apcu \
		opcache \
	; \
	\
	runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-cache --virtual .phpexts-rundeps $runDeps;

###########################################################################
# XDEBUG
###########################################################################

ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
 	apk add --update linux-headers; \
	pecl install xdebug-3.2.0; \
	docker-php-ext-enable xdebug \
;fi

###########################################################################

RUN pecl clear-cache; \
	apk del .build-deps

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ARG UID=1000
ENV UID ${UID}
ARG GID=1000
ENV GID ${GID}

RUN addgroup -g ${GID} app

RUN adduser -u ${UID} -G app -D app

USER app
	
WORKDIR /srv/app