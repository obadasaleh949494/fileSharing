<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;   
use Illuminate\Encryption\EncryptionServiceProvider;   
use liamylian\XRsa;
use \ParagonIE\EasyRSA\EasyRSA;
use \ParagonIE\EasyRSA\KeyPair;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','google2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function test()
    {
        
// or
$priv ="130217266093605594344701171788628418157987147929357078726309724211461544746874238743339931575347388241863468842200965275066004161927361930303667038567751359824644914301606206226441274454572014206245530822788997217472962739231703931078832245246357285812305910284115099315837904357165458152988993187505331588993";

// Load a private key


// Get derived public key
$pub ="65537";

$keyPair = KeyPair::generateKeyPair(2048);

$secretKey = $keyPair->getPrivateKey();
$publicKey = $keyPair->getPublicKey();
echo $secretKey->getKey()."<br>";
echo $publicKey->getKey();

$ciphertext = EasyRSA::encrypt("he", $publicKey);
echo $ciphertext;
$plaintext = EasyRSA::decrypt($ciphertext, $secretKey);
echo "<br>".$plaintext;
  
    }
    /* example of assymtric encryption 
    public function encr()
    {
        $publicKey = '
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7o9A47JuO3wgZ/lbOIOs
Xc6cVSiCMsrglvORM/54StFRvcrxMi7OjXD6FX5fQpUOQYZfIOFZZMs6kmNXk8xO
hgTmdMJcBWolQ85acfAdWpTpCW29YMvXNARUDb8uJKAApsISnttyCnbvp7zYMdQm
HiTG/+bYaegSXzV3YN+Ej+ZcocubUpLp8Rpzz+xmXep3BrjBycAE9z2IrrV2rlwg
TTxU/B8xmvMsToBQpAbe+Cv130tEHsyW4UL9KZY1M9R+UHFPPmORjBKxSZvjJ1mS
UbUYN6PmMry35wCaFCfQoyTDUxBfxTGYqjaveQv4sxx0uvoiLXHt9cAm5Q8KJ+8d
FwIDAQAB
-----END PUBLIC KEY-----
';

$privateKey = '
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEA7o9A47JuO3wgZ/lbOIOsXc6cVSiCMsrglvORM/54StFRvcrx
Mi7OjXD6FX5fQpUOQYZfIOFZZMs6kmNXk8xOhgTmdMJcBWolQ85acfAdWpTpCW29
YMvXNARUDb8uJKAApsISnttyCnbvp7zYMdQmHiTG/+bYaegSXzV3YN+Ej+Zcocub
UpLp8Rpzz+xmXep3BrjBycAE9z2IrrV2rlwgTTxU/B8xmvMsToBQpAbe+Cv130tE
HsyW4UL9KZY1M9R+UHFPPmORjBKxSZvjJ1mSUbUYN6PmMry35wCaFCfQoyTDUxBf
xTGYqjaveQv4sxx0uvoiLXHt9cAm5Q8KJ+8dFwIDAQABAoIBAHkWS3iHy/3zjjtY
TV4NL8NZqO5splGDuqXEMbKzenl3b8cnKHAxY/RVIQsh3tZb9CV8P/Lfj1Fi+nLt
a7mAXWcXO6aONMkmzI1zQ2NL3opoxTRc+GAWd0BW5hcoMBK1CD+ciHkLqAH5xsFc
UFxSc5qfTkb79GMlQZYD/Hk2WwHyj7hAkyxip4ye1EOnH5h8H7vIUjwp+H6Rmt5w
FTiVJbokhzwiczChUJVWgnowegL/qFV+yNfHGGKqVdIQfKdCsHR6jAuKCww5QniN
qDEi/M2Az0R4qfVmf38uMvOJTWaxp08JV4qRyNdh6hhbj+nY1EZ8haOiC7tjz2mJ
XqqKQfkCgYEA95yb5ezTBF4Pbr589OnU6VFdM88BCrKKvSWE8D1fzZZTsXur5k/x
cOwfio4RkmJwMnjuzZN6nvL5QddfcmPWQAoepHR8eA9yhIz57YWgrqE9ZXI8DgMy
SFuy5EkV5vudjDIr7kBXaGuUh3ErZfglyrV/rUfydGdTWyY8phMq/6MCgYEA9qQj
7kb5uyU8nrXoDqKPpy6ijEpVilgy4VR7RuB2vMh74wKI1QQYED+PxfcHe5RP8WGF
Bl+7VnmrGka4xJWeN7GKW4GRx5gRAzg139DXkqwPlXyM3ZR3pLd8wtbxTmJrcPby
A6uNRhGPpuyhDs5hx9z6HvLoCs+O0A9gDaChM/0CgYEAycRguNPpA2cOFkS8l+mu
p8y4MM5eX/Qq34QiNo0ccu8rFbXb1lmQOV7/OK0Znnn+SPKITRX+1mTRPZidWx4F
aLuWSpXtEvwrad1ijuzTiVk0KWUTkKuEHrgyJplzcnvX3nTHnWXqk9kN9+v83CN/
0BVji7TT2YyUvPKEeyOlZxcCgYABFm42Icf+JEblKEYyslLR2OnMlpNT/dmTlszI
XjsH0BaDxMIXtmHoyG7434L/74J+vQBaK9fmpLi1b/RmoYZGFplWl/atm6UPj5Ll
PsWElw+miBsS6xGv/0MklNARmWuB3wToMTx5P6CTit2W9CAIQpgzxLxzN8EYd8jj
pn6vfQKBgQCHkDnpoNZc2m1JksDiuiRjZORKMYz8he8seoUMPQ+iQze66XSRp5JL
oGZrU7JzCxuyoeA/4z36UN5WXmeS3bqh6SinrPQKt7rMkK1NQYcDUijPBMt0afO+
LH0HIC1HAtS6Wztd2Taoqwe5Xm75YW0elo4OEqiAfubAC85Ec4zfxw==
-----END RSA PRIVATE KEY-----
';

$rsa = new RSA($publicKey, $privateKey);

$data = 'abc123hamza';
$encrypted = $rsa->encrypt($data);
$decrypted = $rsa->decrypt($encrypted);
var_dump($decrypted); // 'abc123'



}*/
}
