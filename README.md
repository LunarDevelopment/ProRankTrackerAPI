# PHP Majestic API 

A package to allow communication with Majestic.com API, through production or sandbox environments. 

## Prerequisits 
- An API key from [Majestic API console](https://majestic.com/account/api#api-keys)
- PHP >5.4 
- Composer (optional)

## Installation 

Via composer 

```composer require lunardevelopment/majestic```

Via ZIP

Download this ZIP and manually include 
```php
require_once 'theUnzippedDirectory/src/Majestic.php'
```

## Usage 

See in depth commands and parameters at [Majestic.com API Commands](https://developer-support.majestic.com/api/commands/)

### GetIndexItemInfo 
```php 

    use LunarDevelopment\Majestic; 

    $majestic_api_key = "YOUR_API_KEY";
    $domain = "example.com";
    
    $service = new Majestic($majestic_api_key, false);
    
    $params = array(  
        'datasource'=>'fresh', 
        'item0' => $domain , 
        'items' => 1
    );
    
    $response = $service->executeCommand('GetIndexItemInfo', $params);
    
    $majestic_json_data = json_encode(json_decode($response->getBody())->DataTables->Results->Data[0]);

    dd($majestic_json_data); 

```


### GetBackLinkData 
```php 


    use LunarDevelopment\Majestic; 

    $majestic_api_key = "YOUR_API_KEY";
    $domain = "example.com";

    $service = new Majestic($majestic_api_key, false);

    $params = array(
        'item' => $domain,
        'datasource' => 'fresh',
        'Count' => 1000,
        'Mode' => 1,
        'ShowDomainInfo' => 1,
        'MaxSourceURLsPerRefDomain' => 1,
        'MaxSameSourceURLs' => 1,
        'FilterTopicsRefDomainsMode' => 1
    );

    $response = $service->executeCommand('GetBackLinkData', $params);

    $backlinks = json_decode($response->getBody())->DataTables->BackLinks->Data;

    dd($backlinks); 

```


