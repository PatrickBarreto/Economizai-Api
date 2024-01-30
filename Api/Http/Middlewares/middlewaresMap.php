<?php

use Http\Http;

//DEFAULT
Http::middleware('AccessToken', 'Api\Http\Middlewares\AccessToken\AccessToken', true);

//ROUTE
Http::middleware('Auth', 'Api\Http\Middlewares\Authorization\Authorization');
