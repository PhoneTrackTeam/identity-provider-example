# Identity Provider - IdP


### Starting project

```
docker-compose up -d --build
```

## Accessing project localhost

[http://localhost:8081/](http://localhost:8081/)

## Config Phonetrack

```php
<?php
#./config.php
return [
    'phonetrack' => [
        'account_id' => 1, // Infome aqui a Conta que o usuario tem acesso
        'units_id' => '2' // Infome aqui as Unidades que o usuario tem acesso: 1,2,3,4,5
    ]
];
```

### Routers

- / - Home
- /info.php - Settings
- /login.php - Sign in
- logout.php - Sign out
- /sso.php - SSO with SAML
- /redirect.php - Redirect SAML Response


### Create certificate x509

```
openssl req -newkey rsa:3072 -new -x509 -days 3652 -nodes -out certificate.crt -keyout private_key.pem
```

### Environment with private key path and certificate path

```
PRIVATE_KEY_PATH=/path/to/my/private_key.pem
CERTIFICATE_PATH=/path/to/my/certificate.crt
```

### Login SAML

![idp-fluxo](idp-fluxo.png)