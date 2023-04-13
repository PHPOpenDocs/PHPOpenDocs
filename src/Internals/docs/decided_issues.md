

# Decided issues

When building software some issues are decided for particular reasons, but then the reason for those choices, or even that a choice was made is un-obvious. These are some of their stories.

It is not the case that these things are _never_ going to be changed, it is more the case that to be changed people would: 

* need to understand why the previous choice was made.
* have a strong enough reason to change it.
* have the resolve to suffer the consequences of changing it

### Timezone names

It is not [unheard of](https://bugs.php.net/bug.php?id=66971) [for people](https://bugs.php.net/bug.php?id=73422) [to report bugs](https://bugs.php.net/bug.php?id=76988) [in how timezones](https://bugs.php.net/bug.php?id=70840) [are spelled](https://bugs.php.net/bug.php?id=80254).

They have an assumption that the choice of spelling was made by a PHP contributor. They are not.

PHP uses the standard [Time Zone Database](https://www.iana.org/time-zones) that pretty much every piece of software in the world uses. The timezones listed in there are, mostly, spelled with their most common English spelling. The spelling in the Timezone DB will be updated occasionally, but PHP will always defer to the Timezone DB spelling, for compatibility with other software.  

The internal spelling shouldn't actually matter to end-users, or as one the [maintainers of the Timezone DB wrote](https://mm.icann.org/pipermail/tz/2021-January/029679.html):

> By the way, the choice of spelling should not be important to end users,
> as the tzdb spelling is not intended to be visible to them. End users
> should see their preferred spelling which would typically be Київ, but
> could also be Kyiv, Kænugarður, Κίεβο, 基輔, or whatever else is
> appropriate for the user's locale. The Unicode Common Locale Data
> Repository (CLDR) is a good source for these localized names; see
> <http://cldr.unicode.org/>. If your software application is exposing the
> string "Europe/Kiev" to users who prefer a different name, please send
> bug reports mentioning CLDR to the application's developers.


