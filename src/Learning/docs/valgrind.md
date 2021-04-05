# Valgrind

Valgrind is a suite of tools including a memory usage error checker and a performance measurement tool.


## Simple segfault stacktrace dump

```
valgrind php segfault_example.php

root@0878dc0d6903:/var/app/example/learning# valgrind php segfault_example.php
==63== Memcheck, a memory error detector
==63== Copyright (C) 2002-2015, and GNU GPL'd, by Julian Seward et al.
==63== Using Valgrind-3.12.0.SVN and LibVEX; rerun with -h for copyright info
==63== Command: php segfault_example.php
==63==
==63==
==63== Process terminating with default action of signal 11 (SIGSEGV)
==63==    at 0x6B5E317: kill (syscall-template.S:84)
==63==    by 0x12376C32: ??? (in /usr/lib/php/20190902/posix.so)
==63==    by 0xA8A143C: xdebug_execute_internal (base.c:883)
==63==    by 0x1EBF83: ??? (in /usr/bin/php7.4)
==63==    by 0x424AAF: execute_ex (in /usr/bin/php7.4)
==63==    by 0xA8A0BE6: xdebug_execute_ex (base.c:765)
==63==    by 0x1EBF1D: ??? (in /usr/bin/php7.4)
==63==    by 0x424AAF: execute_ex (in /usr/bin/php7.4)
==63==    by 0xA8A0BE6: xdebug_execute_ex (base.c:765)
==63==    by 0x42B862: zend_execute (in /usr/bin/php7.4)
==63==    by 0x39D2B2: zend_execute_scripts (in /usr/bin/php7.4)
==63==    by 0x339A4F: php_execute_script (in /usr/bin/php7.4)
==63==
==63== HEAP SUMMARY:
==63==     in use at exit: 3,248,412 bytes in 31,184 blocks
==63==   total heap usage: 34,841 allocs, 3,657 frees, 4,714,564 bytes allocated
==63==
==63== LEAK SUMMARY:
==63==    definitely lost: 360 bytes in 15 blocks
==63==    indirectly lost: 0 bytes in 0 blocks
==63==      possibly lost: 2,391,728 bytes in 18,675 blocks
==63==    still reachable: 856,324 bytes in 12,494 blocks
==63==         suppressed: 0 bytes in 0 blocks
==63== Rerun with --leak-check=full to see details of leaked memory
==63==
==63== For counts of detected and suppressed errors, rerun with: -v
==63== ERROR SUMMARY: 0 errors from 0 contexts (suppressed: 474 from 37)

```

## Invalid memory usage




php runtests.php -m


## Performance measurement

Valgrind can be used to measure the number of instructions run by a program. Note, this is not strictly an accurate measurement of performance, but is usually a good indicator of whether a change will be slower or faster.

For example, for the [Closure::fromCallable RFC](https://wiki.php.net/rfc/closurefromcallable) I made two scrips that use either `Closure` or `callable` as the parameter type.



```
# valgrind --tool=callgrind php perf_callable.php
==47== Callgrind, a call-graph generating cache profiler
==47== Copyright (C) 2002-2015, and GNU GPL'd, by Josef Weidendorfer et al.
==47== Using Valgrind-3.12.0.SVN and LibVEX; rerun with -h for copyright info
==47== Command: php perf_callable.php
==47==
==47== For interactive control, run 'callgrind_control -h'.
OK==47==
==47== Events    : Ir
==47== Collected : 116136383
==47==
==47== I   refs:      116,136,383
```


```bash
# valgrind --tool=callgrind php perf_closure.php
==48== Callgrind, a call-graph generating cache profiler
==48== Copyright (C) 2002-2015, and GNU GPL'd, by Josef Weidendorfer et al.
==48== Using Valgrind-3.12.0.SVN and LibVEX; rerun with -h for copyright info
==48== Command: php perf_closure.php
==48==
==48== For interactive control, run 'callgrind_control -h'.
OK==48==
==48== Events    : Ir
==48== Collected : 96614788
==48==
==48== I   refs:      96,614,788
```

| Measurement | Instructions |
| :---------- | -----------: |
|Callable     |  116,136,383 |
|Closure      |   96,614,788 |
|Difference   |   19,521,595 |

i.e. using callgrind we can see that 


Note, callgrind measurements should probably be done without Xdebug enabled, as it seems to drastically increase the number of instructions that are run for the same PHP script.

## Why is it complaining about `zend_string_equal_val` ?

If you run valgrind on most PHP programs, you will almost certainly see something like:

```
==227== Conditional jump or move depends on uninitialised value(s)
==227==    at 0x3C6D12: zend_string_equal_val (in /usr/bin/php7.4)
==227==    by 0x3C7026: ??? (in /usr/bin/php7.4)
==227==    by 0x3A264F: ??? (in /usr/bin/php7.4)
==227==    by 0x13E9F4E4: ??? (in /usr/lib/php/20190902/xmlreader.so)
==227==    by 0x3A0744: zend_startup_module_ex (in /usr/bin/php7.4)
==227==    by 0x3A07CB: ??? (in /usr/bin/php7.4)
==227==    by 0x3ADD11: zend_hash_apply (in /usr/bin/php7.4)
==227==    by 0x3A0A89: zend_startup_modules (in /usr/bin/php7.4)
==227==    by 0x338FCA: php_module_startup (in /usr/bin/php7.4)
==227==    by 0x42C58C: ??? (in /usr/bin/php7.4)
==227==    by 0x1F4843: ??? (in /usr/bin/php7.4)
==227==    by 0x6B4B2E0: (below main) (libc-start.c:291)
```

repeated many times in the output. This apparently is a false positive.

It should be possible to avoid this false detection, by compiling PHP on a system where valgrind is available, and maybe forcing `--with-valgrind` to ensure it is detected, which then does some [magic](https://github.com/php/php-src/blob/5b01c4863fe9e4bc2702b2bbf66d292d23001a18/Zend/zend_string.c#L365). 


### Suppressing valgrind errors

An easier way of suppressing valgrind errors is to tell valgrind to suppress them. There is an example [suppression file](https://github.com/PHPOpenDocs/PHPOpenDocs/containers/php_fpm_debug/valgrind.supp) in this project, and a [script that wraps invocation of valgrind](https://github.com/PHPOpenDocs/PHPOpenDocs/containers/php_fpm_debug/valgrind.sh), which are setup [in the debug PHP container](https://github.com/PHPOpenDocs/PHPOpenDocs/containers/php_fpm_debug/Dockerfile) for this project.


However it may also be convenient to add valgrind suppressions to CI tools, in which case generating a suppression file like this:

```
- echo "{"                                                      >> $HOME/default.supp
- echo "String_Equality_Intentionally_Reads_Uninit_Memory"      >> $HOME/default.supp
- echo "Memcheck:Cond"                                          >> $HOME/default.supp
- echo "fun:zend_string_equal_val"                              >> $HOME/default.supp
- echo "}"
```

And wrapping calls to valgrind with something like this:

```
- echo  "#!/bin/bash"                                           > $HOME/bin/valgrind
- echo "/usr/bin/valgrind --suppressions=$HOME/default.supp \$@" >> $HOME/bin/valgrind
- chmod +x $HOME/bin/valgrind
```

May be useful.

## More info

[valgrind.org](https://valgrind.org/)

[valgrind Introduction](https://programmersought.com/article/82912146110/)

[Valgrind manual suppressing errors](https://www.valgrind.org/docs/manual/manual-core.html#manual-core.suppress)

[Valgrind Suppression File Howto](https://wiki.wxwidgets.org/Valgrind_Suppression_File_Howto)





