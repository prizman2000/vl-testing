FROM node:18.0.0-alpine3.15 AS builder

COPY ./ /app
WORKDIR /app

RUN npm install
RUN npm run build

CMD /bin/sh

# Copy frontend app for nginx
FROM nginx:latest

COPY ./ /var/www/todomvc-app-template
COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

COPY --from=builder /app/dist /var/www/todomvc-app-template/dist
COPY --from=builder /app/node_modules /var/www/todomvc-app-template/node_modules

WORKDIR /var/www/todomvc-app-template
