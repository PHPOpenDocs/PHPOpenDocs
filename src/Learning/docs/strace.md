# Strace

Strace is a tool that allows you to trace system calls and signals. This is incredibly useful for investigating certain types of problems, but also, strace is slightly dangerous.

## Warning: passwords

As strace intercepts and logs system calls, these can easily include api keys. It's not uncommon for people to post logs of strace output which include api keys. 

## Warning: size of output

The amount of output that strace generates can be gigantic. For the example below, where strace is generating output for a running PHP-FPM instance, it's quite easy to generate hundreds of megabytes of log data _per second_. This has a somewhat negative effect on the performance of the server.

For both of those reasons, it's generally a good idea to use strace on a test system in isolation, away from your production environment.

## Example usage

```
strace php debug.php > output.txt 2>&1
```




## Debugging a 



strace -s 4096 php weird.php > weird_output_7.txt 2>&1

https://man7.org/linux/man-pages/man2/ppoll.2.html

> The timeout argument specifies the number of milliseconds that
poll() should block waiting for a file descriptor to become
ready.


## Strace for PHP-FPM


```bash
#!/bin/bash

# If you get a syntax error, this script needs bash not sh.


# -etrace=!open means to trace every system call except open. In addition, the special values all and none have the obvious meanings.
#-etrace=!open
#-e trace=!write.


# Prevent strace from abbreviating arguments?
# You want the -s strsize option, which specifies the maximum length of a string to display (the default is 32).
# -s strsize
# Specify the maximum string size to print (the default is 32). Note that
# filenames are not considered strings and are always printed in full.

# comment in to show total of calls
summarise=""
#summarise="-c"

# Clean out previous run
rm -rf trc/*.trc
# Make sure output directory exists 
mkdir trc

# Allow extra strace args to be passed in.
additional_strace_args="$1"

# Find the master process ID through a magic incantation.
# This works on Debian. Other distros may have slightly different 
# output for `ps auwx` which may require some fiddling.
MASTER_PID=$(ps auwx | grep php-fpm | grep -v grep | grep 'master process'  | cut -d ' ' -f 7)

# Start strace listening to the master PHP-FPM process
nohup strace -r $summarise -p $MASTER_PID -ff -o ./trc/master.follow.trc >"trc/master.$MASTER_PID.trc" 2>&1 &

# loop through all of the processes found from `pgrep php-fpm`
# and start strace listening to them
while read -r pid;
do
if [[ $pid != $MASTER_PID ]]; then
    nohup strace -r $summarise -p "$pid" $additional_strace_args >"trc/$pid.summary.trc" 2>&1 &
fi
done < <(pgrep php-fpm)


# Tell the user 
read -p "Strace running - press [Enter] to stop"

pkill strace
```