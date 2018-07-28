# Token generator for Wowza Token Authentication


INITIALIZE
```
require_once 'TokenAuthGenerator.php';
$token = new TokenAuthGenerator();
```

SET KEY
```
$token->setKey('jJD7DJ0jd8d19');
```

SET EXPIRATION TIME (optional)
```
$token->setExpire(1333497600);
```

SET ALLOW DOMAIN (optional)
```
$token->setRefAllow(array('domain1.com', 'domain2.com'));
```

SET DENY DOMAIN (optional)
```
$token->setRefDeny(array('domain.com', 'MISSING'));
```

ECHO TOKEN
```
echo $token->toString();
```

SAMPLE OUTPUT
```
5351d09e9cdc30cc498703245849ccdc11970c4a328faa77fc75dac3fafef0783e31f9d1d012d4f9dd2fd2659b194a2953d2ad22d8a94014887ca52bd
```
Then append the result to the end of the streaming CDN URL as in the following example:
```    
rtmp://12345.r.cdnsun.net/_definst_/live?token=5351d09e9cdc30cc498703245849ccdc11970c4a328faa77fc75dac3fafef0783e31f9d1d012d4f9dd2fd2659b194a2953d2ad22d8a94014887ca52bd
```

METHOD PARAMETERS

 * setExpire(integer)
   * Number of seconds since Unix time (Epoch time) 
   * UTC based 
   * Must not be earlier than current time

 * setRefAllow(array)
  *  Referrer domain(s) (e.g. domain.com) or path (e.g. domain.com/video/)
  *  Wildcard (*) allowed only at the beginning of a referrer, e.g. *.domain.com
  *  Do not append space at the start & end of a referrer
  *  Domain must fullfill RFC 3490
  *  Path must fullfill RFC 2396
  *  Should not include port (e.g. domain.com:3000/video)
  *  Should not include protocol portion  (e.g. http://domain.com)

 * setRefDeny(array)
   * Same rules as in setRefAllow()
   * Normally setRefAllow() & setRefDeny() are not to be used together, but if this happened setRefAllow() will take precedence over setRefDeny().


ALLOW BLANK / MISSING REFERRER

  Both "SetRefAllow()" & "setRefDeny()" could be configured to allow/deny blank or missing referrer during Token Auth validation.

CONTACT

* W: https://cdnsun.com
* E: info@cdnsun.com
