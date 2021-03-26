The below is a repost of a Slashdot [comment by JustinOpinion](http://ask.slashdot.org/comments.pl?sid=1932550&cid=34743614) that I thought was too great to not repost. It's in response to the question, "How do you prove software testing saves money".



<hr/>


There is a generally-held belief among coders that "doing it right, the first time" and "rewriting this mess" will save money in the long-term, and that managers are idiots for not seeing that. This can, of course, be true. But it isn't always true, and coders are sometimes projecting their OCD-desire to have nice code (and sometimes suffering from ["I didn't write it so it must be crap"](http://en.wikipedia.org/wiki/Not_Invented_Here) syndrome) and assuming that this will translate into the dollars and cents that the company cares about.

Sometimes it's worth it; sometimes it's really not.

The thing about money is that it is both non-linear (double the money doesn't necessarily have double the value; sometimes it has more than double because you can overcome barriers; sometimes it has less because of diminishing returns, etc.) and temporally varying (inflation, time-value-of-money, etc.). Because of this, it can actually make economic sense to do something in a half-baked way, and "pay the price" later on (in terms of higher support costs, or even having to totally re-do a task/project). For example, in cases where you "absolutely need it now" (the value of having it finished soon becomes larger than down-the-road problems) or because you can't spare the cash right now (the value of using that money to do something else right now is larger than the down-the-road problems). (If you want a physics analogy, notice that money is not a conservative force-field: it is a path-dependent process...)

I'm not saying that it always makes sense to do slipshod work now and suffer the consequences later. There are plenty of dumb managers who over-value short-term gains compared to long-term. But that doesn't mean that the optimal solution is to spend massive effort up-front; there is such a thing as being too much of a perfectionist. And, importantly, the right answer will vary wildly depending on circumstances and the current state of the business. A startup may need a product to show (anything!) in order to secure more money. Doing it "right" will mean bankruptcy, which is far worse than having to keep fixing and maintaining a piece of shoddy code for years to come. A very well-established company, on the other hand, may do serious damage to their reputation if they release something buggy; and can probably afford to delay a release.

Actually figuring out the cost/benefit is not simple. In principle this is what good managers and good accountants are there to do: to figure out how best to allocate the finite resources. If you think you've found a way to reduce costs by implementing testing, then by all means show them the data that supports your case. However don't assume that just because testing will make the product better, that it actually makes sense from a business perspective.

<hr/>

This is one of the reasons why code written for businesses is horrible. It's not that the programmers are totally incompetent, it's just that a lot of the time there is no business case for making the code be as good as the programmers would like.
