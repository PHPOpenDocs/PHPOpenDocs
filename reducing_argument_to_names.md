MONDAY, MARCH 16, 2009
Operator Overloading Ad Absurdum
Bruce Eckel's recent blog post on The Positive Legacy of C++ and Java has opened a small can of worms on the Internet. The argument is on operator overloading[1]: tool of Satan or road to bliss? The arguing that's resulted is the usual well thought out, reasoned debate I've come to expect from software engineers. Which is to say, not at all.

The Argument Against
Eckel mentions issues with resource management as being the primary reason that operator overloading was seen as a bad thing in C++ and therefore shouldn't be seen as bad in managed environments. But the consensus in the debates is that's not the real issue and Gosling's writing indicates that that wasn't why he dropped it from Java.

The real arguments against operator overloading boil down to abuse of a feature. Even the most ardent anti-operator folks recognize that it is occasionally a good thing to name something +. Their argument against it tends to look something like this.

The problem is abuse. Somebody will name something '+' when it has nothing to do with the common notion of '+'. The resulting confusion is a bigger downside than the benefits of allowing programmers to be flexible in naming.
Phrased that way it sounds like a reasoned trade-off. Yeah, sometimes + is good, but it can lead to more confusion than it helps resolve so let's scrap the whole idea. But watch as I do a little search and replace.

Reductio
The problem is abuse. Somebody will name something 'plus' when it has nothing to do with the common notion of 'plus'.
I've sneakily dropped the last clause but I'll get back to it. Without it, and with the textual replacement, my new statement is obviously true. Naming a function or method "plus" when it doesn't do anything like "plus" is a recipe for throwing people right off the track. I can do it one more time and get another true statement.

The problem is abuse. Somebody will name something 'getName' when it has nothing to do with the common notion of 'getName'.
The statement is still true. The convention in Java is that getName should just return the value of the name property with minimal side effects. But I've seen Java methods named getName used to make permanent changes to a shared database. Certainly you can imagine other ways that getName (or get_name or whatever) is entirely the wrong name for something in any other language - like if it adds numbers.

What's that leave us with? If I can seemingly search and replace with anything and still have a true statement then I must have bit of universal wisdom here.

The problem is abuse. For all valid names X that evoke a common conception, somebody will name something 'X' when it has nothing to do with the common notion of 'X'.
Ad Absurdum
Earlier I removed one phrase from the argument and now I want to stick it back in to the universal wisdom.

The problem is abuse. For all valid names X that evoke a common conception, somebody will name something 'X' when it has nothing to do with the common notion of 'X'. The resulting confusion is a bigger downside than the benefits of allowing programmers to be flexible in naming.
In other words, programmers simply shouldn't be allowed to name things - or at least shouldn't be allowed to use words found in a dictionary.

Where's the Flaw in the Argument
By following the structure of the original argument and with a common observation that misnamed things cause confusion I came to the conclusion that we can't let programmers name things at all or at least can't let them use common words. Good luck trying to figure out a useful process where programmers don't name things or always use gibberish. In the meantime, I'm just going to call the result absurd which leads to the conclusion that the original argument is flawed. To see the problem with the original argument let me make a few observations.

Programmers with good taste try to name things reasonably.
Most teams have a coding guideline.
Smart teams have at least partial code review process to ensure general code quality.
There is a downside to inappropriate naming, but smart teams and individuals already work to mitigate that problem. So the downsides of abuse don't outweigh the benefits of flexible naming because we keep an eye out for abuse in our own code and in others.

This isn't an argument for always trusting programmers with all power. For instance, garbage collection really does take away a huge source of error created by manual memory management. What this is is an argument that operator overloading doesn't change in any fundamental way the core problem of misnaming things nor does it add additional burden to the solutions we already have. If you concede that occasionally + is a useful name (e.g. for complex numbers, matrices, etc.) then the only reasonable conclusion is that programmers should be allowed to use it as a name when it makes sense and strongly discouraged from using when it doesn't - exactly the same guidelines as for any other name.

On the other hand, teams without guidelines, reviews, or good programmers are screwed with or without operator overloading. They've got problems that cannot be fixed at the language level.

footnotes
[1] Throughout this post I've used the common phrase "operator overloading." In a strict pedantic sense that's not really what happens in Scala and Haskell. Those languages simply don't have many operators in the way that most C derived languages do. Instead, they have a very flexible grammar for naming things. In Scala 2 + 3 is the same as sending a + message to a 2 object with a 3 argument 2.+(3) and in Haskell 2 + 3 is the same as calling the + function with 2 and 3 as arguments (+) 2 3. Either approach is actually conceptually much simpler than the C++ approach of having a few special operators plus rules for overloading them. None-the-less, by "operator overloading" I mean Scala and Haskell style flexibility as well as C++'s rigid rules or any other mechanism that lets users define the meaning of symbols like + for their own types.