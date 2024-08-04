<?php
declare(strict_types=1);

namespace App\Middleware;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Cake\Http\Response;
use Firebase\JWT\ExpiredException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Firebase\JWT\SignatureInvalidException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Cake\Http\Exception\UnauthorizedException;

/**
 * JwtAuthentication middleware
 */
class JwtAuthenticationMiddleware implements MiddlewareInterface
{

    protected $secretKey;
    protected $allowedAlgorithms = ['HS256'];

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }


    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authHeader = $request->getHeaderLine('Authorization');
        $token = null;

        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches))
            $token = $matches[1];


        if ($token) {

            try {
                JWT::decode($token, new Key($this->secretKey, 'HS256'));
            } catch (ExpiredException $e) {
                return $this->sendErrorResponse('Token expirado');
            } catch (SignatureInvalidException $e) {
                return $this->sendErrorResponse('Assinatura inválida');
            } catch (Exception $e) {
                return $this->sendErrorResponse('Token inválido');
            }

        }

        return $handler->handle($request);
    }


    private function sendErrorResponse(string $message)
    {
        return new Response([
            'status' => 401,
            'body' => json_encode(['message' => $message])
        ]);
    }
}
