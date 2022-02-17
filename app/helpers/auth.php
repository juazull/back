<?php
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

require_once __DIR__ . '/../vendor/autoload.php';
// TODO: Mover a un archivo externo...
const SECRET_KEY = 'FVfFLlwGC+LGmta0/Ax74KfVnpVkOwJINAmJ+E5FiL0=';

/**
 * Crea un token de JWT.
 *
 * @param int $id
 * @return string
 */
function createToken(int $id): string {
    $config = Configuration::forSymmetricSigner(
        new Sha256(),
        InMemory::base64Encoded(SECRET_KEY)
    );

    $builder = $config->builder();
    $token = $builder
        ->issuedBy('https://davinci.edu.ar')
        ->issuedAt(new DateTimeImmutable())
        ->withClaim('id', $id)
        ->getToken($config->signer(), $config->signingKey());

    return $token->toString();
}

/**
 * Parsea el $token provisto como string, e informa de si es un token válido.
 * De serlo, retorna los datos pertinentes del token, como el id del usuario.
 *
 * @param string $token
 * @return array|bool
 */
function parseAndVerifyToken(string $token) {
    $config = Configuration::forSymmetricSigner(
        new Sha256(),
        InMemory::base64Encoded(SECRET_KEY)
    );

    $parsedToken = $config->parser()->parse($token);

    try {
        $constraints = [
            new SignedWith($config->signer(), $config->signingKey()),
            new IssuedBy('https://davinci.edu.ar'),
        ];

        $config->validator()->assert($parsedToken, ...$constraints);

        return [
            'id' => $parsedToken->claims()->get('id')
        ];
    } catch(\Exception $e) {
        return false;
    }
}
