<?php

declare(strict_types = 1);

namespace NamingThings;

/**
 * @return Verb[]
 */
function getVerbs(): array
{

    $verbs = [];

//$verbs[] = Verb(
//    '',
//    "",
////    ['']
//);


    $acquireReleaseDifference = "Acquire/release differ from open/close in that acquire/release typically indicate that the underlying resource has a limit of how many times it can be opened at once, whereas for open/close the underlying resource can (theoretically) be opened as many times as needed at once.";


// $verbs[] = Verb('abandon', '', []);
// $verbs[] = Verb('abort', '', []);
// $verbs[] = Verb('accept', '', []);
// $verbs[] = Verb('access', '', []);
// $verbs[] = Verb('accumulate', '', []);

    $verbs[] = Verb(
        'acquire',
        "Asks to be given control over some resource in a computer. E.g. database lock, large amount of memory." . $acquireReleaseDifference,
        ['release']
    );

// $verbs[] = Verb('action', '', []);
// $verbs[] = Verb('activate', '', []);
// $verbs[] = Verb('add to', '', []);
// $verbs[] = Verb('add', '', []);
// $verbs[] = Verb('address', '', []);
// $verbs[] = Verb('adjust', '', []);
// $verbs[] = Verb('advance', '', []);
// $verbs[] = Verb('advise', '', []);
// $verbs[] = Verb('aggregate', '', []);
// $verbs[] = Verb('align', '', []);
// $verbs[] = Verb('allocate', '', []);
// $verbs[] = Verb('allow', '', []);
// $verbs[] = Verb('alter', '', []);
// $verbs[] = Verb('analyze', '', []);
// $verbs[] = Verb('animate', '', []);
// $verbs[] = Verb('append', '', []);
// $verbs[] = Verb('apply', '', []);
// $verbs[] = Verb('arrange', '', []);
// $verbs[] = Verb('array', '', []);
// $verbs[] = Verb('assert', '', []);
// $verbs[] = Verb('assign', '', []);
// $verbs[] = Verb('associate', '', []);
// $verbs[] = Verb('attach to', '', []);
// $verbs[] = Verb('attach', '', []);
// $verbs[] = Verb('attempt', '', []);
// $verbs[] = Verb('attribute', '', []);
// $verbs[] = Verb('audit', '', []);
// $verbs[] = Verb('augment', '', []);
// $verbs[] = Verb('authenticate', '', []);
// $verbs[] = Verb('average', '', []);
// $verbs[] = Verb('back up', '', []);
// $verbs[] = Verb('back', '', []);
// $verbs[] = Verb('base', '', []);
// $verbs[] = Verb('batch', '', []);
// $verbs[] = Verb('begin', '', []);
// $verbs[] = Verb('bind', '', []);
// $verbs[] = Verb('blend', '', []);
// $verbs[] = Verb('block', '', []);
// $verbs[] = Verb('break', '', []);
// $verbs[] = Verb('bring to', '', []);
// $verbs[] = Verb('bring', '', []);
// $verbs[] = Verb('buffer', '', []);
// $verbs[] = Verb('build', '', []);
// $verbs[] = Verb('bulk', '', []);
// $verbs[] = Verb('cache', '', []);
// $verbs[] = Verb('calculate', '', []);
// $verbs[] = Verb('call back', '', []);
// $verbs[] = Verb('call', '', []);
// $verbs[] = Verb('can', '', []);
// $verbs[] = Verb('cancel', '', []);
// $verbs[] = Verb('capture', '', []);
// $verbs[] = Verb('cast', '', []);
// $verbs[] = Verb('catch', '', []);
// $verbs[] = Verb('center', '', []);
// $verbs[] = Verb('change state', '', []);
// $verbs[] = Verb('change', '', []);
// $verbs[] = Verb('channel', '', []);
// $verbs[] = Verb('check out', '', []);
// $verbs[] = Verb('check', '', []);
// $verbs[] = Verb('choose', '', []);
// $verbs[] = Verb('clean up', '', []);
// $verbs[] = Verb('clean', '', []);
// $verbs[] = Verb('clear', '', []);
// $verbs[] = Verb('click', '', []);
// $verbs[] = Verb('clip', '', []);
// $verbs[] = Verb('clone', '', []);


    $verbs[] = Verb(
        'close',
        "Tell the operating system that you have finished using a " . noun_link('resource') . " in the computer, and that any pending commands sent to that resource should be finalised. e.g. any pending writes should be written to a file.",
        ['open']
    );

// $verbs[] = Verb('close', '', []);
// $verbs[] = Verb('code', '', []);
// $verbs[] = Verb('coerce', '', []);
// $verbs[] = Verb('collapse', '', []);
// $verbs[] = Verb('collect', '', []);
// $verbs[] = Verb('color', '', []);
// $verbs[] = Verb('combine', '', []);
// $verbs[] = Verb('command', '', []);
// $verbs[] = Verb('comment', '', []);
// $verbs[] = Verb('commit', '', []);
// $verbs[] = Verb('compare', '', []);
// $verbs[] = Verb('compensate', '', []);
// $verbs[] = Verb('compile', '', []);
// $verbs[] = Verb('complete', '', []);
// $verbs[] = Verb('compose', '', []);
// $verbs[] = Verb('compress', '', []);
// $verbs[] = Verb('compute', '', []);
// $verbs[] = Verb('configure', '', []);
// $verbs[] = Verb('confirm', '', []);
// $verbs[] = Verb('connect', '', []);
// $verbs[] = Verb('construct', '', []);
// $verbs[] = Verb('consume', '', []);
// $verbs[] = Verb('content', '', []);
// $verbs[] = Verb('continue', '', []);
// $verbs[] = Verb('control', '', []);
// $verbs[] = Verb('convert', '', []);
// $verbs[] = Verb('copy', '', []);
// $verbs[] = Verb('correct', '', []);
// $verbs[] = Verb('count', '', []);

    $verbs[] = Verb(
        'create',
        'Creates a object from the data passed in. Usually returns an object rather than storing it internally. May throw an exception if the data does not meet some required conditions (e.g. is invalid).'
    );

// $verbs[] = Verb('create', '', []);
// $verbs[] = Verb('cut', '', []);
// $verbs[] = Verb('deactivate', '', []);
// $verbs[] = Verb('debug', '', []);
// $verbs[] = Verb('declare', '', []);
// $verbs[] = Verb('decode', '', []);
// $verbs[] = Verb('decompile', '', []);
// $verbs[] = Verb('decrease', '', []);
// $verbs[] = Verb('decrement', '', []);
// $verbs[] = Verb('decrypt', '', []);
// $verbs[] = Verb('default', '', []);
// $verbs[] = Verb('defer', '', []);
// $verbs[] = Verb('define', '', []);
// $verbs[] = Verb('delay', '', []);
// $verbs[] = Verb('delegate', '', []);
// $verbs[] = Verb('delete', '', []);
// $verbs[] = Verb('demand', '', []);
// $verbs[] = Verb('dequeue', '', []);
// $verbs[] = Verb('derive', '', []);
// $verbs[] = Verb('describe', '', []);
// $verbs[] = Verb('deserialize', '', []);
// $verbs[] = Verb('destroy', '', []);
// $verbs[] = Verb('detach', '', []);
// $verbs[] = Verb('detect', '', []);
// $verbs[] = Verb('determine', '', []);
// $verbs[] = Verb('disable', '', []);
// $verbs[] = Verb('discard', '', []);
// $verbs[] = Verb('disconnect', '', []);
// $verbs[] = Verb('discover', '', []);
// $verbs[] = Verb('dismiss', '', []);
    $verbs[] = Verb('dispatch', '', ['execute']);
// $verbs[] = Verb('display', '', []);
// $verbs[] = Verb('dispose', '', []);
// $verbs[] = Verb('distance', '', []);
// $verbs[] = Verb('divide', '', []);
// $verbs[] = Verb('do', '', []);
// $verbs[] = Verb('dock', '', []);
// $verbs[] = Verb('document', '', []);
// $verbs[] = Verb('double', '', []);
// $verbs[] = Verb('download', '', []);
// $verbs[] = Verb('drag', '', []);
// $verbs[] = Verb('draw', '', []);
// $verbs[] = Verb('drop down', '', []);
// $verbs[] = Verb('drop', '', []);
// $verbs[] = Verb('dump', '', []);
// $verbs[] = Verb('duplicate', '', []);
// $verbs[] = Verb('edit', '', []);
// $verbs[] = Verb('emit', '', []);
// $verbs[] = Verb('empty', '', []);
// $verbs[] = Verb('emulate', '', []);
// $verbs[] = Verb('enable', '', []);
// $verbs[] = Verb('encode', '', []);
// $verbs[] = Verb('encrypt', '', []);
// $verbs[] = Verb('end', '', []);
// $verbs[] = Verb('enqueue', '', []);
// $verbs[] = Verb('ensure', '', []);
// $verbs[] = Verb('enter', '', []);
// $verbs[] = Verb('enumerate', '', []);
// $verbs[] = Verb('equal', '', []);
// $verbs[] = Verb('erase', '', []);
// $verbs[] = Verb('err', '', []);
// $verbs[] = Verb('escape', '', []);
// $verbs[] = Verb('estimate', '', []);
// $verbs[] = Verb('evaluate', '', []);
// $verbs[] = Verb('except', '', []);
// $verbs[] = Verb('exclude', '', []);
    $verbs[] = Verb('execute', '', ['dispatch']);
// $verbs[] = Verb('exit', '', []);
// $verbs[] = Verb('expand', '', []);
// $verbs[] = Verb('expect', '', []);
// $verbs[] = Verb('explain', '', []);
// $verbs[] = Verb('export', '', []);
// $verbs[] = Verb('extend', '', []);
// $verbs[] = Verb('extract', '', []);
// $verbs[] = Verb('fail', '', []);
// $verbs[] = Verb('fall back', '', []);
// $verbs[] = Verb('fault', '', []);
// $verbs[] = Verb('feature', '', []);
// $verbs[] = Verb('fetch', '', []);
// $verbs[] = Verb('field', '', []);
// $verbs[] = Verb('fill', '', []);
// $verbs[] = Verb('filter', '', []);
// $verbs[] = Verb('finalize', '', []);


    $verbs[] = Verb(
        'find',
        "Attempts to locate a piece of data from a containing storage type. If the containing storage does not contain any data by the name parameter, very likely to return null."
    );

// $verbs[] = Verb('finish', '', []);
// $verbs[] = Verb('fire', '', []);
// $verbs[] = Verb('fit', '', []);
// $verbs[] = Verb('fix up', '', []);
// $verbs[] = Verb('fix', '', []);
// $verbs[] = Verb('flag', '', []);
// $verbs[] = Verb('flatten', '', []);
// $verbs[] = Verb('flush', '', []);
// $verbs[] = Verb('focus', '', []);
// $verbs[] = Verb('force', '', []);
// $verbs[] = Verb('format', '', []);
// $verbs[] = Verb('forward', '', []);
// $verbs[] = Verb('free', '', []);
// $verbs[] = Verb('freeze', '', []);
// $verbs[] = Verb('function', '', []);
// $verbs[] = Verb('gather', '', []);
// $verbs[] = Verb('generate', '', []);

    $verbs[] = Verb(
        'get (class property)',
        "Returns a value from the class/data being operated on. No 'get' method should do heavy calculations or throw exception. Or gets a value from a containing storage type",
        ['set']
    );

    $verbs[] = Verb(
        'get (from container)',
        "Takes a key as a parameter and returns a value from a container (e.g. array, map) corresponding to that key. Generally throws an exception if the container does contain a value corresponding to that key.",
        ['has']
    );

// $verbs[] = Verb('get in', '', []);
// $verbs[] = Verb('get word', '', []);
// $verbs[] = Verb('go back', '', []);
// $verbs[] = Verb('go forward', '', []);
// $verbs[] = Verb('go to', '', []);
// $verbs[] = Verb('go', '', []);
// $verbs[] = Verb('grant', '', []);
// $verbs[] = Verb('group', '', []);
// $verbs[] = Verb('grow', '', []);
// $verbs[] = Verb('handle', '', []);

    $verbs[] = Verb(
        'has',
        "Checks whether a value is available from a containing storage type e.g. does an array contain a key with a particular name. Almost always returns a boolean."
    );

// $verbs[] = Verb('hash', '', []);
// $verbs[] = Verb('have', '', []);
// $verbs[] = Verb('help', '', []);
// $verbs[] = Verb('hex', '', []);
// $verbs[] = Verb('hide', '', []);
// $verbs[] = Verb('highlight', '', []);
// $verbs[] = Verb('hit', '', []);
// $verbs[] = Verb('hook up', '', []);
// $verbs[] = Verb('hook', '', []);
// $verbs[] = Verb('host', '', []);
// $verbs[] = Verb('identify', '', []);
// $verbs[] = Verb('ignore', '', []);
// $verbs[] = Verb('image', '', []);
// $verbs[] = Verb('impersonate', '', []);
// $verbs[] = Verb('implement', '', []);
// $verbs[] = Verb('import', '', []);
// $verbs[] = Verb('include', '', []);
// $verbs[] = Verb('increase', '', []);
// $verbs[] = Verb('increment', '', []);
// $verbs[] = Verb('indent', '', []);
// $verbs[] = Verb('index', '', []);
// $verbs[] = Verb('infer', '', []);
// $verbs[] = Verb('inflate', '', []);
// $verbs[] = Verb('initialize', '', []);
// $verbs[] = Verb('initiate', '', []);
// $verbs[] = Verb('input', '', []);
// $verbs[] = Verb('insert', '', []);
// $verbs[] = Verb('install', '', []);
// $verbs[] = Verb('instance', '', []);
// $verbs[] = Verb('instantiate', '', []);
// $verbs[] = Verb('interpolate', '', []);
// $verbs[] = Verb('interpret', '', []);
// $verbs[] = Verb('interrupt', '', []);
// $verbs[] = Verb('intersect', '', []);
// $verbs[] = Verb('invalid', '', []);
// $verbs[] = Verb('invalidate', '', []);
// $verbs[] = Verb('invite', '', []);
// $verbs[] = Verb('invoke', '', []);
// $verbs[] = Verb('issue' '', []);
// $verbs[] = Verb('iterate', '', []);
// $verbs[] = Verb('join', '', []);
// $verbs[] = Verb('key', '', []);
// $verbs[] = Verb('kill', '', []);
// $verbs[] = Verb('label', '', []);
// $verbs[] = Verb('last', '', []);
// $verbs[] = Verb('launch', '', []);
// $verbs[] = Verb('lay out', '', []);
// $verbs[] = Verb('leave', '', []);
// $verbs[] = Verb('like', '', []);
// $verbs[] = Verb('limit', '', []);
// $verbs[] = Verb('line', '', []);
// $verbs[] = Verb('link', '', []);
// $verbs[] = Verb('list', '', []);
// $verbs[] = Verb('listen', '', []);
// $verbs[] = Verb('load', '', []);
// $verbs[] = Verb('locate', '', []);
// $verbs[] = Verb('lock', '', []);
// $verbs[] = Verb('log', '', []);
// $verbs[] = Verb('look up', '', []);
// $verbs[] = Verb('make', '', []);
// $verbs[] = Verb('map', '', []);
// $verbs[] = Verb('mark', '', []);
// $verbs[] = Verb('marshal', '', []);
// $verbs[] = Verb('match', '', []);
// $verbs[] = Verb('measure', '', []);
// $verbs[] = Verb('merge', '', []);
// $verbs[] = Verb('message', '', []);
// $verbs[] = Verb('modify', '', []);
// $verbs[] = Verb('monitor', '', []);
// $verbs[] = Verb('mouse', '', []);
// $verbs[] = Verb('move', '', []);
// $verbs[] = Verb('multiply', '', []);
// $verbs[] = Verb('must', '', []);
// $verbs[] = Verb('name', '', []);
// $verbs[] = Verb('navigate', '', []);
// $verbs[] = Verb('near', '', []);
// $verbs[] = Verb('need', '', []);
// $verbs[] = Verb('negate', '', []);
// $verbs[] = Verb('normalize', '', []);
// $verbs[] = Verb('notify', '', []);
// $verbs[] = Verb('number', '', []);
// $verbs[] = Verb('obtain', '', []);
// $verbs[] = Verb('offset', '', []);


    $verbs[] = Verb(
        'open',
        "Ask the operating system to open a " . noun_link('resource') . " in the computer. This operation may fail, and the returned value needs to be checked to be valid.",
        ['close']
    );


// $verbs[] = Verb('open', '', []);
// $verbs[] = Verb('optimize', '', []);
// $verbs[] = Verb('order', '', []);
// $verbs[] = Verb('out', '', []);
// $verbs[] = Verb('output', '', []);
// $verbs[] = Verb('override', '', []);
// $verbs[] = Verb('page', '', []);
// $verbs[] = Verb('paint', '', []);
// $verbs[] = Verb('parent', '', []);
// $verbs[] = Verb('parse', '', []);
// $verbs[] = Verb('partition', '', []);
// $verbs[] = Verb('paste', '', []);
// $verbs[] = Verb('pause', '', []);
// $verbs[] = Verb('peek', '', []);
// $verbs[] = Verb('peer', '', []);
// $verbs[] = Verb('perform', '', []);
// $verbs[] = Verb('persist', '', []);
// $verbs[] = Verb('pick', '', []);
// $verbs[] = Verb('ping', '', []);
// $verbs[] = Verb('place', '', []);
// $verbs[] = Verb('plain', '', []);
// $verbs[] = Verb('play', '', []);
// $verbs[] = Verb('point', '', []);
    $verbs[] = Verb('pop', 'Take an item from a container e.g. array, list, queue, or stack.', ['push']);
// $verbs[] = Verb('populate', '', []);
// $verbs[] = Verb('position', '', []);
// $verbs[] = Verb('post', '', []);
// $verbs[] = Verb('postprocess', '', []);
// $verbs[] = Verb('prepare for', '', []);
// $verbs[] = Verb('prepare', '', []);
// $verbs[] = Verb('preprocess', '', []);
// $verbs[] = Verb('preview', '', []);
// $verbs[] = Verb('print', '', []);
// $verbs[] = Verb('probe', '', []);
// $verbs[] = Verb('process', '', []);
// $verbs[] = Verb('project', '', []);
// $verbs[] = Verb('promote', '', []);
// $verbs[] = Verb('prompt', '', []);
// $verbs[] = Verb('propagate', '', []);
// $verbs[] = Verb('provide', '', []);
// $verbs[] = Verb('prune', '', []);
// $verbs[] = Verb('publish', '', []);
// $verbs[] = Verb('purge', '', []);
    $verbs[] = Verb('push', 'Add an item into a container e.g. array, list, queue, or stack.', ['pop']);
// $verbs[] = Verb('put', '', []);
// $verbs[] = Verb('query', '', []);
// $verbs[] = Verb('queue', '', []);
// $verbs[] = Verb('quote', '', []);
// $verbs[] = Verb('raise', '', []);
// $verbs[] = Verb('range', '', []);
// $verbs[] = Verb('read', '', []);
// $verbs[] = Verb('realize', '', []);
// $verbs[] = Verb('rebind', '', []);
// $verbs[] = Verb('rebuild', '', []);
// $verbs[] = Verb('recalculate', '', []);
// $verbs[] = Verb('receive', '', []);
// $verbs[] = Verb('recognize', '', []);
// $verbs[] = Verb('record', '', []);
// $verbs[] = Verb('recover', '', []);
// $verbs[] = Verb('recreate', '', []);
// $verbs[] = Verb('recycle', '', []);
// $verbs[] = Verb('redo', '', []);
// $verbs[] = Verb('reduce', '', []);
// $verbs[] = Verb('reference', '', []);
// $verbs[] = Verb('reflect', '', []);
// $verbs[] = Verb('refresh', '', []);
// $verbs[] = Verb('register', '', []);

    $verbs[] = Verb(
        'release',
        "Release control over a resource given from a call to a " . verb_link('acquire') . "." . $acquireReleaseDifference,
        ['acquire']
    );

// $verbs[] = Verb('reload', '', []);
// $verbs[] = Verb('remap', '', []);
// $verbs[] = Verb('remove', '', []);
// $verbs[] = Verb('rename', '', []);
// $verbs[] = Verb('render', '', []);
// $verbs[] = Verb('reopen', '', []);
// $verbs[] = Verb('reorder', '', []);
// $verbs[] = Verb('repeat', '', []);
// $verbs[] = Verb('replace', '', []);
// $verbs[] = Verb('reply', '', []);
// $verbs[] = Verb('report', '', []);
// $verbs[] = Verb('reposition', '', []);
// $verbs[] = Verb('request', '', []);
// $verbs[] = Verb('require', '', []);
// $verbs[] = Verb('reserve', '', []);

    $verbs[] = Verb(
        'reset',
        "Reset and object back to some initial state ready to be re-used.",
        ['acquire']
    );

// $verbs[] = Verb('reset', '', []);
// $verbs[] = Verb('resize', '', []);
// $verbs[] = Verb('resolve', '', []);
// $verbs[] = Verb('restore', '', []);
// $verbs[] = Verb('resume', '', []);
// $verbs[] = Verb('retrieve', '', []);
// $verbs[] = Verb('return', '', []);
// $verbs[] = Verb('reverse', '', []);
// $verbs[] = Verb('revert', '', []);
// $verbs[] = Verb('revoke', '', []);
// $verbs[] = Verb('rewrite', '', []);
// $verbs[] = Verb('right', '', []);
// $verbs[] = Verb('rotate', '', []);
// $verbs[] = Verb('round', '', []);
// $verbs[] = Verb('route', '', []);
// $verbs[] = Verb('run', '', []);
// $verbs[] = Verb('save', '', []);
// $verbs[] = Verb('scale', '', []);
// $verbs[] = Verb('scan', '', []);
// $verbs[] = Verb('schedule', '', []);
// $verbs[] = Verb('score', '', []);
// $verbs[] = Verb('screen', '', []);
// $verbs[] = Verb('scroll', '', []);
// $verbs[] = Verb('seal', '', []);
// $verbs[] = Verb('search', '', []);
// $verbs[] = Verb('secure', '', []);
// $verbs[] = Verb('seek', '', []);
// $verbs[] = Verb('select', '', []);
// $verbs[] = Verb('send', '', []);
// $verbs[] = Verb('sequence', '', []);
// $verbs[] = Verb('serialize', '', []);
// $verbs[] = Verb('service', '', []);
// $verbs[] = Verb('set up', '', []);

    $verbs[] = Verb(
        'set',
        "Set a property of an object, or a global variable. No 'set' method should do heavy calculations. If the value being set is invalid, the function might throw an exception.",
        ['get']
    );

// $verbs[] = Verb('set', '', []);
// $verbs[] = Verb('shift', '', []);
// $verbs[] = Verb('should', '', []);
// $verbs[] = Verb('show', '', []);
// $verbs[] = Verb('shrink', '', []);
// $verbs[] = Verb('shut down', '', []);
// $verbs[] = Verb('sign', '', []);
// $verbs[] = Verb('signal', '', []);
// $verbs[] = Verb('simplify', '', []);
// $verbs[] = Verb('sink', '', []);
// $verbs[] = Verb('size', '', []);
// $verbs[] = Verb('skip', '', []);
// $verbs[] = Verb('snap', '', []);
// $verbs[] = Verb('sniff', '', []);
// $verbs[] = Verb('sort', '', []);
// $verbs[] = Verb('source', '', []);
// $verbs[] = Verb('speak', '', []);
// $verbs[] = Verb('split', '', []);
// $verbs[] = Verb('start up', '', []);
// $verbs[] = Verb('start', '', []);
// $verbs[] = Verb('stop', '', []);
// $verbs[] = Verb('store', '', []);
// $verbs[] = Verb('stream', '', []);
// $verbs[] = Verb('strip', '', []);
// $verbs[] = Verb('sub', '', []);
// $verbs[] = Verb('submit', '', []);
// $verbs[] = Verb('subscribe to', '', []);
// $verbs[] = Verb('subscribe', '', []);
// $verbs[] = Verb('subtract', '', []);
// $verbs[] = Verb('sum', '', []);
// $verbs[] = Verb('suppress', '', []);
// $verbs[] = Verb('suspend', '', []);
// $verbs[] = Verb('swap', '', []);
// $verbs[] = Verb('switch', '', []);
// $verbs[] = Verb('sync', '', []);
// $verbs[] = Verb('synchronize', '', []);
// $verbs[] = Verb('take', '', []);
// $verbs[] = Verb('target', '', []);
// $verbs[] = Verb('task', '', []);
// $verbs[] = Verb('term', '', []);
// $verbs[] = Verb('terminate', '', []);
// $verbs[] = Verb('test', '', []);
// $verbs[] = Verb('thread', '', []);
// $verbs[] = Verb('throw', '', []);
// $verbs[] = Verb('time', '', []);
// $verbs[] = Verb('toggle', '', []);

    $verbs[] = Verb(
        'to',
        "Convert an object from one type to another. e.g. 'toArray', 'toJson'. Generally would not take any parameters, but might if there was some option on how the formatting is to be done.",
        ['get']
    );

// $verbs[] = Verb('tool', '', []);
// $verbs[] = Verb('top', '', []);
// $verbs[] = Verb('trace', '', []);
// $verbs[] = Verb('track', '', []);
// $verbs[] = Verb('transfer', '', []);
// $verbs[] = Verb('transform', '', []);
// $verbs[] = Verb('transition', '', []);
// $verbs[] = Verb('translate', '', []);
// $verbs[] = Verb('transpose', '', []);
// $verbs[] = Verb('treat', '', []);
// $verbs[] = Verb('tree', '', []);
// $verbs[] = Verb('trigger', '', []);
// $verbs[] = Verb('trim', '', []);
// $verbs[] = Verb('truncate', '', []);
// $verbs[] = Verb('try', '', []);
// $verbs[] = Verb('type', '', []);
// $verbs[] = Verb('undo', '', []);
// $verbs[] = Verb('unescape', '', []);
// $verbs[] = Verb('unhook', '', []);
// $verbs[] = Verb('uninitialize', '', []);
// $verbs[] = Verb('uninstall', '', []);
// $verbs[] = Verb('union', '', []);
// $verbs[] = Verb('unload', '', []);
// $verbs[] = Verb('unlock', '', []);
// $verbs[] = Verb('unregister', '', []);
// $verbs[] = Verb('unsubscribe', '', []);
// $verbs[] = Verb('unwrap', '', []);
// $verbs[] = Verb('update', '', []);
// $verbs[] = Verb('upgrade', '', []);
// $verbs[] = Verb('upload', '', []);
// $verbs[] = Verb('use', '', []);
// $verbs[] = Verb('validate', '', []);
// $verbs[] = Verb('verify', '', []);
// $verbs[] = Verb('view', '', []);
// $verbs[] = Verb('visit', '', []);
// $verbs[] = Verb('wait', '', []);
// $verbs[] = Verb('walk', '', []);
// $verbs[] = Verb('web', '', []);

    $verbs[] = Verb(
        'with',
        'Return a copy of the original object, with one or more properties changed e.g. `$user.withFirstName("John")`',
    );

// $verbs[] = Verb('wire', '', []);
// $verbs[] = Verb('wrap', '', []);
// $verbs[] = Verb('write', '', []);
// $verbs[] = Verb('zoom', '', []);


    return $verbs;
}
