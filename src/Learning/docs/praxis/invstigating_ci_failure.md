
# 

unixodbc.h header not found
https://github.com/php/php-src/issues/10565

## Sanity check

Checked the [error log](https://github.com/php/php-src/actions/runs/4148457300/jobs/7176463762) was

```
Run make -j$(/usr/bin/nproc) >/dev/null
In file included from /usr/include/sql.h:19,
                 from /home/runner/work/php-src/php-src/ext/odbc/php_odbc_includes.h:107,
                 from /home/runner/work/php-src/php-src/ext/odbc/php_odbc.c:33:
/usr/include/sqltypes.h:56:10: fatal error: unixodbc.h: No such file or directory
   56 | #include "unixodbc.h"
      |          ^~~~~~~~~~~~
compilation terminated.
```

Yep, that looks like a problem.

## 


ls -l /usr/include
cat /usr/include/sqltypes.h

https://packages.microsoft.com/ubuntu/20.04/prod focal/main amd64 unixodbc-dev amd64 2.3.11 [42.1 kB]