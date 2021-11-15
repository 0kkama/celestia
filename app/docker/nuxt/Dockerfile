FROM node:14

RUN npm install pm2 -g

RUN mkdir -p /app

WORKDIR /app

RUN mkdir -m777 /.npm; \
    mkdir -m777 /.config; \
    mkdir -m777 /.cache; \
    mkdir -m777 /.local; \
    mkdir -m777 /.pm2; \
    mkdir -m777 /.tailwindcss

ENV HOST 0.0.0.0

EXPOSE 3000

CMD npm run start
