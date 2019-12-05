#Symfony 4 CI/CD Pipeline

## Checkout project code and boot up docker
```
git clone https://github.com/jianzhong/free2.git
cd free2/docker
docker-compose up -d
```

## Build application
```
docker container exec -it php composer install
```

## View in your browser

url: http://localhost:8080/user