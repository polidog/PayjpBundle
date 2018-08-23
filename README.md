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


```
<?php

namespace App\Command;


use Polidog\PayjpBundle\Payjp;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CustomerShowCommand extends Command
{
    /**
     * @var Payjp
     */
    private $payjp;

    public function __construct(Payjp $payjp)
    {
        $this->payjp = $payjp;
        parent::__construct(null);
    }

    protected function configure()
    {
        $this->setName('app:customer:retrieve');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this->payjp->customer->retrieve('cus_141a8ff031230845375b8181293f');
        var_dump($result);
    }


}
```