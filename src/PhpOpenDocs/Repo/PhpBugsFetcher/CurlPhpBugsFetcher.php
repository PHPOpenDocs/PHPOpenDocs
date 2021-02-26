<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Repo\PhpBugsFetcher;

use PhpOpenDocs\Model\PhpBugsMaxComment;

// Example data
// http://127.0.0.1/api.php?type=comment_details&comment_id=1
// {"comment_id":1,"error":"bug report is private", "bug_id": 3}
// {"comment_id":1,"email":"asda.. at bar dot com", "bug_id": 3}
//
// {"max_comment_id":1}


class CurlPhpBugsFetcher implements PhpBugsFetcher
{
    public function getPhpBugsMaxComment(): PhpBugsMaxComment
    {
        $source = 'http://10.254.254.254:8080/api.php?type=max_comment_id';

        $headers = [ 'User-Agent: phpopendocs.com' ];
        $data = fetchDataWithHeaders($source, $headers);

        return PhpBugsMaxComment::fromArray($data);
    }
}
