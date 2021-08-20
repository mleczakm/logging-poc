FROM golang:1.16-alpine AS build
WORKDIR /src
COPY hello.go ./
ENV GO111MODULE=off CGO_ENABLED=0 GOOS=linux GOARCH=amd64
RUN go build -o /out/example .

FROM scratch AS bin
COPY --from=build /out/example /

EXPOSE 8090
ENTRYPOINT ["/example"]