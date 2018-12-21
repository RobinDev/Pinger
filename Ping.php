<?php

@set_time_limit(0);
error_reporting(0);

include 'vendor/autoload.php';

$args = new Symfony\Component\Console\Input\ArgvInput($argv);

if (!$args->getParameterOption('url=')) {
    echo die ('no url... use -url http://my-domain.tld');
}

echo 'Ping starting'.chr(10).chr(10);

$name = $args->getParameterOption('name=') ? $args->getParameterOption('name=') : $args->getParameterOption('url=');
$url  = $args->getParameterOption('url=');
$feed = $args->getParameterOption('feed=') ? $args->getParameterOption('feed=') : null;
$file = $args->getParameterOption('source=') ? $args->getParameterOption('source=') : 'pinglist.txt';

$plainList = file_get_contents('pinglist.txt');

foreach (array_unique(explode(chr(10), $plainList)) as $service) {
    $ixr = new IXR\Client\Client($service, false, null, 15, 15); // Two last number are timed out
    echo $service.chr(10);

    if (null === $feed) {
            $ixr->query('weblogUpdates.ping', $name, $url);
    } else {
        $extendedPing = $ixr->query('weblogUpdates.extendedPing', $name, $url, $feed);
        if(!$extendedPing) $ixr->query('weblogUpdates.ping', $name, $url, $feed);
    }

    var_dump($ixr->getResponse()); //$ixr->getErrorMessage()
}
