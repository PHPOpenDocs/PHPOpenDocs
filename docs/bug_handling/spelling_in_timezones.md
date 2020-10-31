# Spelling of timezones

The spelling of timezones


However, these constants are not



Diverging from standards is generally a bad idea, but also in this case aliasing it in PHP core would means potential for future work and arguments over how to spell things.



## Example bugs

https://bugs.php.net/bug.php?id=80254
https://bugs.php.net/bug.php?id=70840
https://bugs.php.net/bug.php?id=66971

## Notes


https://github.com/eggert/tz/commit/b2eede3d1b62c43d0121dd2f6e790b97f29da7b7

# From Paul Eggert (2018-10-03):
# As is usual in tzdb, Ukrainian zones use the most common English spellings.
# For example, tzdb uses Europe/Kiev, as "Kiev" is the most common spelling in
# English for Ukraine's capital, even though it is certainly wrong as a
# transliteration of the Ukrainian "Київ".  This is similar to tzdb's use of
# Europe/Prague, which is certainly wrong as a transliteration of the Czech
# "Praha".  ("Kiev" came from old Slavic via Russian to English, and "Prague"
# came from old Slavic via French to English, so the two cases have something
# in common.)  Admittedly English-language spelling of Ukrainian names is
# controversial, and some day "Kyiv" may become substantially more popular in
# English; in the meantime, stick with the traditional English "Kiev" as that
# means less disruption for our users.





