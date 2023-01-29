server {

    listen 80;

    server_name phpopendocs.com *.phpopendocs.com;
    # add_header X-DJA-proxy phpopendocs;

    root /var/home/phpopendocs/PHPOpenDocs/app/public;

    index index.html index.htm;

    location / {
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_pass http://localhost:8007;
    }

    access_log /var/log/nginx/access.phpopendocs.com.log timed_combined;
    error_log /var/log/nginx/error.phpopendocs.com.log;
}
