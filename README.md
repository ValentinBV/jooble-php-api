

# jooble-php-api
This small library is designed to work with jooble site api.

See https://ru.jooble.org/api/about

For example:

    $httpClient = new GuzzleHttp\Client();
    $joobleRequest = new valentinbv\Jooble\Request($httpClient);
    $joobleRequest->setAccessToken('your access token');
    try {
	    $result = $joobleRequest->search(
	        ['keywords' => 'developer']
	    );
	    } catch(\Exception $e) {
	    	//some action
	    }
    }
    

The $result array contains the result of the query to the jooble api server according to the documentation https://ru.jooble.org/api/about

For install from packagist

**composer require valentinbv/jooble-php-api**

For install from git add to composer.json:

    {
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/ValentinBV/jooble-php-api.git"
            }
        ],
        "require": {
            "valentinbv/jooble-php-api": "dev-master"
        }
    }
