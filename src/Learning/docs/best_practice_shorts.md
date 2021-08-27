
## Exclude files from being packaged in a library

Add a .gitattributes file to your repo.   


```
/.github        export-ignore
/containers     export-ignore
/tests          export-ignore
/composer.phar  export-ignore
```

More info in the article '[GitAttributes for PHP Composer Projects](https://php.watch/articles/composer-gitattributes)'.

## How to randomize a list

A common mistake junior programmers make is to try to randomize a list with code that swaps elements at random:

```php
function randomize_list(array $data)
{
    for ($i = 0; $i < 10000; $i += 1) {
        $index_1 = random_int(0, count($data) - 1);
        $index_2 = random_int(0, count($data) - 1);
        $temp = $data[$index_2];
        $data[$index_2] = $data[$index_1];
        $data[$index_1] = $temp;
    }

    return $data; 
}
```

```php
function randomize_list(array $data)
{
    for ($i = 0; $i < count($data); $i += 1) {
        $random_index = random_int(0, count($data) - 1);
        $temp = $data[$i];
        $data[$i] = $data[$random_index];
        $data[$random_index] = $temp;
    }

    return $data;
}
```


## Ignoring bulk change commits with git blame

One problem with cleaning up code-style in a project is that it makes it hard to use the git blame feature. 

This can be avoided by creating a file that lists which commits to ignore for the purposes of `git blame`:

```
$ cat .git-blame-ignore-revs 
# Conversion to PSR-2 code style
237de8a6367a88649a3f161112492d0d70d83707

# Fix line endings
df0ee6b006ee0f90cccc18b71ced290f6cae18d9
```

And then telling git to use that file:
```
$ git config blame.ignoreRevsFile .git-blame-ignore-revs
```

Full details are in the blog post [Ignoring bulk change commits with git blame](https://www.moxio.com/blog/43/ignoring-bulk-change-commits-with-git-blame) by Arnout Boks.

## Sleep in long running code

A computer will try to run your code as fast as possible, which is normally a good thing. But when you have a long-running process having something run at 100% CPU for weeks is not good as: 

* it uses more electrical power than it should.
* your monitoring can't tell when it gets 'stuck' processing an item.

By adding a call to `usleep(5);` in the loop somewhere, you will massively reduce power usage while only having a trivial slowdown in processing time. Additionally your monitoring system will now see that process sitting at less than 5% CPU usage most of the time, so if it ever gets stuck repeatedly attempting to process the same data, it's much easier to observe. 

## SQL always use parameterized queries

## Whitelisting strings

## intval numbers