#Free2

This application is developed with Symfony 4 framework. The form page controller class is src/Controller/UserController.php. View template files are under the templates/user folder. Since it's using Symfony Form component, the form page has csrf taken embeded.

The form validation logic is in the loadValidatorMetadata() method in the src/Entity/User.php. The postcode validator is using a custom validator class and a constraint class which can be found under the src/Validator/Constraints folder. As this is a demostration, it dose not use the postcode lookup returning data to dynamically redner an address form fields. In a real world app, the postcode lookup data could be populated into the form fields.

The form data is stored in the User entity class and handled by Doctrine. So it free of SQL injection.

Postcode lookup service is accessed via Guzzle Http client and is configured in config/packages/eight_points_guzzle.yaml

## Checkout project code and boot up docker
```
git clone https://github.com/jianzhong/free2.git
cd free2/docker
docker-compose up -d
```

## Build application
```
docker container exec -it php composer install
docker container exec -it php bin/console doctrine:migrations:migrate -n
```

## View in your browser

url: http://localhost:8080/user
