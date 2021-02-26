<?php


$sha = `git rev-parse HEAD`;

$sha = trim($sha);

$config = <<< END
<?php

// Generated from autoconf.source.php

function getGeneratedConfigOptions(): array
{
    \$options = [
        'cache' => ${'twig.cache'},
        'debug' => ${'twig.debug'},
        'assets_force_refresh' => ${'assets_force_refresh'},
        'sha' => '${'sha'}',
    ];

    \$result['phpopendocs'] = \$options;
    
    return \$result; 
}

END;

return $config;

