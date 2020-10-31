
FROM node:14.4.0-stretch-slim

WORKDIR /var/app

# COPY package.json .
# RUN npm install --quiet
# COPY . .

RUN apt-get update -qq && DEBIAN_FRONTEND=noninteractive apt-get install -y git

CMD tail -f /var/app/containers/npm/README_npm.md