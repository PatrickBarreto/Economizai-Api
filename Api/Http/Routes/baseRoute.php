<?php

use Http\Http;

Http::get('/', 
            function($request){
                Http::response();
            });