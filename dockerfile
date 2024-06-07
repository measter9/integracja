FROM bitnami/laravel:11.1.1-debian-12-r0
RUN sudo apt update -y
COPY . /app
WORKDIR /app
RUN npm install
RUN composer install
# RUN php artisan migrate --force && php artisan db:seed
CMD  ["bash"]
