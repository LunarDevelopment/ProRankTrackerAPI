# PHP ProRankTracker API 

A package to allow communication with ProRankTracker.com API, through production environment.
 
## Prerequisits 
- An API key from [proranktracker.com API console](https://proranktracker.com/tools/api_doc)
- PHP >5.4 
- Composer (optional)

## Installation 

Via composer 

```composer require lunardevelopment/proranktracker```

Via ZIP

Download this ZIP and manually include 
```php
require_once 'theUnzippedDirectory/src/ProRankTracker.php';
```

## Usage 

See in depth commands and parameters at [ProRankTracker.com API Commands](https://developer-support.proranktracker.com/api/commands/)

### Get URLs and terms being tracked 
```php 

    use LunarDevelopment\ProRankTracker; 
    
    $email = "YOUR_EMAIL";
    $password = "YOUR_PASSWORD";

    $prt = new ProRankTracker($email, $password);
    
    $data = $prt->urls_get(array(
        'include_terms' => 1,
        'per_page' => 100
    ));
    
    if ($data->result == 'error') {
        var_dump($data) ;
        die;
    }

    dd($data->data->urls); 

```


### Add a new URL and terms to be tracked
```php 

    use LunarDevelopment\ProRankTracker; 
    
    $email = "YOUR_EMAIL";
    $password = "YOUR_PASSWORD";

    $url = "http://example.com";

    $prt = new ProRankTracker($email, $password);

    $response = $prt->urls_new(array(
        'url' => $newUrl,
        'terms' => array(
            "term 1", 
            "term 2"
        ),
        'se_ids' => 1, // 1 is Google.com, 3 is Bing.com, refer se.get
        'group_ids' => array(52532),
        'note' => 'Test FROM API',
    ));

    if ($response->result == 'error') {
        dd($response->error_message);
    }

    dd($response); 

```


