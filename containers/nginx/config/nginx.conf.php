<?php

function createServerBlock(
    array $portStrings,
    array $domains,
    string $root,
    string $indexFilename,
    string $phpBackend,
    string $description
) {

  $portsInfo = '';
  foreach ($portStrings as $portString) {
      $portsInfo .= "        listen $portString;\n";
  }

  $domainInfo = implode(" ", $domains);

  $output = <<< CONFIG
  
    # $description
  
    server {
        server_name $domainInfo;
$portsInfo
        root $root;

        location ~* ^(.+).(bmp|bz2|css|gif|doc|gz|html|ico|jpg|jpeg|js|mid|midi|png|rtf|rar|pdf|ppt|tar|tgz|txt|wav|xls|zip)$ {
            #access_log off;
        try_files \$uri /$indexFilename?file=$1.$2&q=\$uri&\$args;
            expires 20m;
            add_header Pragma public;
            add_header Cache-Control "public, no-transform, max-age=1200, s-maxage=300";
        }

        location / {
            try_files \$uri /$indexFilename?q=\$uri&\$args;
        }

        location /$indexFilename {
            # Mitigate https://httpoxy.org/ vulnerabilities
            fastcgi_param HTTP_PROXY "";
            include /var/app/containers/nginx/config/fastcgi.conf;
            fastcgi_param SCRIPT_FILENAME \$document_root/\$fastcgi_script_name;
            fastcgi_read_timeout 300;
            fastcgi_pass $phpBackend;
        }
    }
CONFIG;

  return $output;
}




$appNormalBlock = createServerBlock(
    $portStrings   = ['80', '8000'],
    $domains = [
        '*.phpopendocs.com',
        'phpopendocs.com',
        '*.phpopendocs.com',
        'phpopendocs.com'
    ],
    $root = '/var/app/app/public',
    $indexFilename = 'index.php',
    $phpBackend = 'php_fpm:9000',
    'app normal block'
);

$appDebugBlock = createServerBlock(
    $portStrings   = ['8001'],
    $domains = [
        '*.phpopendocs.com',
        'phpopendocs.com'
    ],
    $root = '/var/app/app/public',
    $indexFilename = 'index.php',
    $phpBackend = 'php_fpm_debug:9000',
    'app debug block'
);

if (${'system.build_debug_php_containers'} === false ||
    ${'system.build_debug_php_containers'} === 'false') {
    $appDebugBlock = '';
}


$output = <<< OUTPUT

user www-data;
worker_processes auto;
pid /run/nginx.pid;
#include /etc/nginx/modules-enabled/*.conf;
daemon off;

events {
    worker_connections 768;
    # multi_accept on;
}

http {
    sendfile on;
    tcp_nopush on;
    tcp_nodelay on;
    keepalive_timeout 65;
    types_hash_max_size 2048;
    client_max_body_size 10m;
    server_tokens off;

    include /var/app/containers/nginx/config/mime.types;
    default_type application/octet-stream;


log_format main '\$http_x_real_ip - \$remote_user [\$time_local] '
    '"\$request" \$status \$body_bytes_sent '
    '"\$http_referer" "\$http_user_agent"';


    access_log /dev/stdout main;
    # access_log off;
    error_log /dev/stderr;

    gzip on;
    gzip_vary on;
    gzip_proxied any;
    #Set what content types may be gzipped.
    gzip_types text/plain text/css application/json application/javascript application/x-javascript text/javascript text/xml application/xml application/rss+xml application/atom+xml application/rdf+xml;

$appNormalBlock

$appDebugBlock

}

OUTPUT;

return $output;


