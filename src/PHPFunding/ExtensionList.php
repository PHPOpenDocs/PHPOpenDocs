<?php

declare(strict_types=1);


namespace PHPFunding;


class ExtensionList
{

    /**
     * @var PHPExtension[]
     */
    private array $extensions;


    public function __construct()
    {
        $this->init();
    }


    private function init()
    {
        $this->extensions[] = (new PHPExtension("Imagick"))->
            addMaintainer("Danack", ['Github' => 'https://github.com/sponsors/Danack']);

        // "yaml",

        $this->extensions[] = (new PHPExtension("Xdebug"))->
            addMaintainer("Derick Rethans", [
                'Github' => 'https://github.com/sponsors/derickr',
                'Xdebug support page' => 'https://xdebug.org/support'
        ]);

        $this->extensions[] = (new PHPExtension("Redis"))->
            addMaintainer("Nicolas Favre-Felix", [])->
            addMaintainer("Michael Grunder", ['Github' => 'https://github.com/sponsors/michael-grunder'])->
            addMaintainer("Pavlo Yatsukhnenko", [])
        ;

        $this->extensions[] = (new PHPExtension("APCu"))->
            addMaintainer("Joe Watkins", [])->
            addMaintainer("Anatol Belski", [])->
            addMaintainer("Remi Collet ", ['Remi homepage' => 'https://blog.remirepo.net/'])->
            addMaintainer("Nikita Popov", [])
        ;

//        $this->extensions[] = (new PHPExtension(""))->
//            addMaintainer("", [])->
//            addMaintainer("", [])
//        ;
//            "memcached",
//            "timezonedb",
//            "zip",
//            "htscanner",
//            "mongodb",
//            "mongo",
//            "memcache",
//            "APC",
//        $this->extensions[] = (new PHPExtension("Swoole"))->
//            addMaintainer("Shen Zhe", [])->
//            addMaintainer("Han Tianfeng", [])->
//            addMaintainer("QiHao ChenCao", [])->
//            addMaintainer("Lufei", [/* https://github.com/sy-records*/])
//        ;
//            "amqp",
//            "mcrypt",
//            "ssh2",
//            "pecl_http",
//            "igbinary",
//            "oci8",
//            "mailparse",
//            "geoip",
//            "uploadprogress",
//            "gnupg",
//            "pcov",
//            "xhprof",
//            "intl",
//            "oauth",
//            "couchbase",
//            "PDO",
//            "sqlsrv",
//            "pdo_sqlsrv",
//            "pdflib",
//            "gearman",
//            "apcu_bc",
//            "mogilefs",
//            "event",
//            "Mosquitto",
//            "gRPC",
//            "rdkafka",
//            "PDO_MYSQL",
//            "ast",
//            "Fileinfo",
//            "hprose",
//            "ev",
//            "raphf",
//            "stomp",
//            "json",
//            "libsodium",
//        ];
    }

    /**
     * @return PHPExtension[]
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }

}