<?php
    return [
        // Change the following path to make the package accessible at the path you want.
        // All routes of this package will have the following prefix.
        'base_path'=>'/admin/hierarchies', 

        // Path where fontawesome is. This should be relative to your document root / public
        'fontawesome_path' => '/assets/font-awesome',

        // use a full path of your custom middleware[s]
        // e.g. \App\Http\Middleware\Admin::class
        // these middlewares apply to all the package routes.
        // 'web' is required as the first guard. Do not remove.
        'middleware'=> ['web','auth']
    ];

