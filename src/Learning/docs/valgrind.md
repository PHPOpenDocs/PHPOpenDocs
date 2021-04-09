# Valgrind

Valgrind is a suite of tools including a memory usage error checker and a performance measurement tool. It's also a very convenient way of getting a stack trace for when programs [segfault](https://en.wikipedia.org/wiki/Segmentation_fault).


## Simple segfault stacktrace dump

The simplest use for valgrind is to generate a [stack trace](https://en.wikipedia.org/wiki/Stack_trace).

Running a test PHP script through valgrind with the command `valgrind php segfault_example.php` gives this output:

```
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
```

## Memcheck

Valgrind detects many types of errors related to memory allocation or usage that are common bugs in C/C++ programs.

This is really useful when developing PHP extensions as it can help track down bugs in your code.


### Detecting reads of unitialized memory


```
==13745== Conditional jump or move depends on uninitialised value(s)
==13745==    at 0x4F14676: DistortImage (quantum.h:92)
==13745==    by 0x5589D47: MogrifyImage (mogrify.c:1428)
==13745==    by 0x558D22A: MogrifyImages (mogrify.c:8848)
==13745==    by 0x550FCBB: ConvertImageCommand (convert.c:3239)
==13745==    by 0x55B2BDF: MagickCommandGenesis (mogrify.c:168)
==13745==    by 0x400984: main (convert.c:81)
```

This error message is telling us that a bit of code is reading from a memory location that has been allocated, but not written to. Which means the value read will be a random piece of data.


### Detecting memory leaks

One of the common problems with PHP extension is forgetting to free memory. The memcheck part of valgrind will 

```
==19200== 1 bytes in 1 blocks are still reachable in loss record 1 of 90
==19200==    at 0x4C28F9F: malloc (vg_replace_malloc.c:236)
==19200==    by 0x6CE8091: strdup (strdup.c:43)
==19200==    by 0x54AF652: el_init (in /usr/lib/x86_64-linux-gnu/libedit.so.2.11)
==19200==    by 0x54A2C8C: rl_initialize (in /usr/lib/x86_64-linux-gnu/libedit.so.2.11)
==19200==    by 0x72F468: zm_startup_readline (in /usr/bin/php5)
==19200==    by 0x69919D: zend_startup_module_ex (in /usr/bin/php5)
==19200==    by 0x6A5253: zend_hash_apply (in /usr/bin/php5)
==19200==    by 0x69CE99: zend_startup_modules (in /usr/bin/php5)
==19200==    by 0x64530F: php_module_startup (in /usr/bin/php5)
==19200==    by 0x72F72C: php_cli_startup (in /usr/bin/php5)
==19200==    by 0x42B217: main (in /usr/bin/php5)
==19200==
==19200== 1 bytes in 1 blocks are still reachable in loss record 2 of 90
==19200==    at 0x4C279F2: calloc (vg_replace_malloc.c:467)
==19200==    by 0x54A2AF5: rl_initialize (in /usr/lib/x86_64-linux-gnu/libedit.so.2.11)
==19200==    by 0x72F468: zm_startup_readline (in /usr/bin/php5)
==19200==    by 0x69919D: zend_startup_module_ex (in /usr/bin/php5)
==19200==    by 0x6A5253: zend_hash_apply (in /usr/bin/php5)
==19200==    by 0x69CE99: zend_startup_modules (in /usr/bin/php5)
==19200==    by 0x64530F: php_module_startup (in /usr/bin/php5)
==19200==    by 0x72F72C: php_cli_startup (in /usr/bin/php5)
==19200==    by 0x42B217: main (in /usr/bin/php5)
```

The full capabilities of memcheck are quite complex. Reading the [fine valgrind manual](https://www.valgrind.org/docs/manual/mc-manual.html) is recommended.


### Memory check in PHP 

The PHP test suite can use
php runtests.php -m

https://bugs.php.net/bugs-getting-valgrind-log.php





The full detail



--track-origins=yes








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

i.e. using callgrind we can see that using callable as the parameter type instead of Closure is about 20% slower.

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





