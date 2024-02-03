FROM php:8.1-fpm

# Defina seu usuário
ARG user=ivo

# Instale as dependências do sistema
RUN apt-get update && apt-get install -y \
    sudo \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && curl -fsSL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs npm

# Crie o usuário "ivo"
RUN useradd -ms /bin/bash $user

# Remova a senha do usuário
RUN passwd -d $user

# Adicione o usuário ao grupo "sudo" e permita que ele execute comandos sudo sem senha
RUN usermod -aG sudo $user
RUN echo "$user ALL=(ALL) NOPASSWD:ALL" > /etc/sudoers.d/$user

# Limpe o cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instale extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Obtenha o Composer mais recente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure o diretório de trabalho
WORKDIR /var/www

RUN chown -R www-data:www-data /var/www

# Copie as configurações PHP personalizadas
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

USER $user
