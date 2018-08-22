# PayjpBundle

SymfonyBundle the PAY.JP for PHP.

## Requirements
PHP7.1+

## Install

```
composer req polidog/payjp-bundle
```

## Configuration

```
// AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Polidog\PayjpBundle\PolidogPayjpBundle(),
        // ...
    );
}
```

```
// app/config/polidog_payjp.yaml

polidog_payjp:
    public_key: <your public key>
    secret_key: <your secret_key>
```
 
## Using


