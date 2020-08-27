<?php

// Import Auth API routes
foreach (File::allFiles(__DIR__ . '/Api/v1/Routes') as $route_file) {
    require $route_file->getPathname();
}

