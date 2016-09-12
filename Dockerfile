FROM alpine:3.4

RUN apk --update add bash curl openjdk7-jre openssl

RUN mkdir /app

WORKDIR /app

RUN wget https://github.com/OpenRefine/OpenRefine/releases/download/2.6-rc.2/openrefine-linux-2.6-rc.2.tar.gz
RUN tar xzf openrefine-linux-2.6-rc.2.tar.gz
RUN rm -f openrefine-linux-2.6-rc.2.tar.gz

# TODO https://mareklecian.cz/update-jython-knihovny-v-openrefine/

COPY . /code
