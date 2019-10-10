<script type="text/javascript" src="/js/AES/pidcrypt.js"></script>  
<script type="text/javascript" src="/js/AES/pidcrypt_util.js"></script>  
<script type="text/javascript" src="/js/AES/asn1.js"></script>  
<script type="text/javascript" src="/js/AES/jsbn.js"></script>  
<script type="text/javascript" src="/js/AES/rng.js"></script>  
<script type="text/javascript" src="/js/AES/prng4.js"></script>  
<script type="text/javascript" src="/js/AES/rsa.js"></script>  
<script type="text/javascript" src="/js/jsbn.js"></script>  
<script type="text/javascript" src="/js/rng.js"></script>  
<script type="text/javascript" src="/js/prnj4.js"></script>  
<script type="text/javascript" src="/js/rsa.js"></script>  

     <p id="h1"> </p>
     <h1 >hello</h1>

<button onclick="myFunction()">Try it</button>

     <script>
      function myFunction (){
var rsa = new RSAKey();
rsa.setPublic('-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCRsHlxbPD3dsHxisTkNiGysXmoNGi/lm9V6VbVPCJsi1GtCMkM7vYtCqWg8KdsLhNuIKK6nNP24BS9HWln0Rpz+T2D99dp9yK0wB3CPVC/XDcMmmIgVudXGOwc5iOae6zyrCkJq37txm33xqYjDCtmo4uuAQbGztFeOyaTyW1HtQIDAQAB-----END PUBLIC KEY-----');

// encrypt using RSA
var data = rsa.encrypt('hello world');
alert(data);
}
</script>