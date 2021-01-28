# About PHP OpenDocs

One of the problems with the PHP manual site is that it is a monolithic repo, which results in all curation decisions needing to go through a single nexus.

Instead of having all content under a single repo, OpenDocs is an experiment in delegating responsibility for each section of a website to separate organisations.

All of the content should be related to PHP or closely related technologies, but other than that, pretty much anything goes.


## Principles

### Each section should be in a separate repo

Each section should be in a separate repo, so that any suggestions of edits, corrections or ideas of how to improve it, can be discussed by people who maintain that section, rather than by everyone involved in this site. 

### Site must be self-contained

All of the content for the site should be self-contained after being deployed (i.e. no dynamic fetching of content after deployment). This is so that the site can be archived, shipped on CD, inspected for appropriate content. The site will redeploy itself every day, 

### Content must be forkable

At some point people may just disagree with how a particular section is maintained. Rather than leading to a fight for control over the repo that contains that section, it should be possible for people to fork that content, and maintain it how they prefer it to be maintained.

### Content must be remixable

At some point people may disagree with how this website is run, and so wish to port the content contained in each of the sections for their own site.

This site is explicitly setup from the start to make that possible.


## Future plans

### API support

Some content would be greatly enhanced by having support for API calls to other sites. e.g. the whole of the [phpimagick.com](https://phpimagick.com) set of examples. This will be supported at some point.

### Custom CSS per section

This will be needed quite soon...

### Discussions

The PHP community does not have a good set of tools for discussing issues. This is something I've been thinking about a lot, but will take some time to implement and setup.