<?php

declare(strict_types = 1);

namespace NamingThings;

$verbs = [];

//$verbs[] = new Verb(
//    '',
//    "",
////    ['']
//);

$acquireReleaseDifference = " Acquire/release differ from open/close in that acquire/release typically indicate that the underlying resource has a limit of how many times it can be opened at once, whereas for open/close the underlying resource can (theoretically) be opened as many times as needed at once.";

$verbs[] = new Verb(
    'acquire',
    "Asks to be given control over some resource in a computer. E.g. database lock, large amount of memory." . $acquireReleaseDifference,
    ['release']
);

$verbs[] = new Verb(
    'close',
    "Tell the operating system that you have finished using a " . noun_link('resource') . " in the computer, and that any pending commands sent to that resource should be finalised. e.g. any pending writes should be written to a file.",
    ['open']
);

$verbs[] = new Verb(
    'create',
    'Creates a new object from the data passed in. Usually returns an object rather than storing it internally. May throw an exception if the data does not meet some required conditions (e.g. is invalid).'
);



$verbs[] = new Verb(
    'find',
    "Attempts to locate a piece of data from a containing storage type. If the containing storage does not contain any data by the name parameter, very likely to return null."
);

$verbs[] = new Verb(
    'get',
    "Returns a value from the class/data being operated on. No 'get' method should do heavy calculations or throw exception. Or gets a value from a containing storage type",
    ['set']
);

$verbs[] = new Verb(
    'has',
    "Checks whether a value is available from a containing storage type e.g. does an array contain a key with a particular name. Almost always returns a boolean."
);

$verbs[] = new Verb(
    'open',
    "Ask the operating system to open a " . noun_link('resource') . " in the computer. This operation may fail, and the returned value needs to be checked to be valid.",
    ['close']
);

$verbs[] = new Verb(
    'release',
    "Release control over a resource given from a call to a " . verb_link('acquire') ."." . $acquireReleaseDifference,
    ['acquire']
);

$verbs[] = new Verb(
    'reset',
    "Reset and object back to some initial state ready to be re-used.",
    ['acquire']
);

$verbs[] = new Verb(
    'set',
    "Set a property of an object, or a global variable. No 'set' method should do heavy calculations. If the value being set is invalid, the function might throw an exception.",
    ['get']
);

$verbs[] = new Verb(
    'with',
    'Return a copy of the original object, with one or more properties changed e.g. `$user.withFirstName("John")`',
);

$verbs[] = new Verb(
    'to',
    "Convert an object from one type to another. e.g. 'toArray', 'toJson'. Generally would not take any parameters, but might if there was some option on how the formatting is to be done.",
    ['get']
);


return $verbs;
