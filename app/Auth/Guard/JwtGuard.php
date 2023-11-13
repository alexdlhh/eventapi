<?php

namespace App\Auth\Guard;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Tymon\JWTAuth\JWTAuth;

class JwtGuard implements Guard
{
    use GuardHelpers;

    protected $jwtAuth;

    public function __construct(UserProvider $provider, JWTAuth $jwtAuth)
    {
        $this->provider = $provider;
        $this->jwtAuth = $jwtAuth;
    }

    public function check()
    {
        try {
            return $this->jwtAuth->parseToken()->authenticate();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function validate(array $credentials = [])
    {
        try {
            return $this->jwtAuth->attempt($credentials);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function user()
    {
        if ($this->jwtAuth->parser()->setRequest($this->request)->hasToken()) {
            try {
                return $this->jwtAuth->parseToken()->authenticate();
            } catch (\Exception $e) {
                return false;
            }
        }

        return false;
    }

    public function id()
    {
        return $this->jwtAuth->parseToken()->getPayload()->get('sub');
    }

    public function getToken()
    {
        return $this->jwtAuth->getToken();
    }

    public function setToken($token)
    {
        $this->jwtAuth->setToken($token);
    }

    public function getPayload()
    {
        return $this->jwtAuth->getPayload();
    }

    public function getManager()
    {
        return $this->jwtAuth->manager();
    }

    public function getBlacklist()
    {
        return $this->jwtAuth->manager()->getBlacklist();
    }

    public function getPayloadFactory()
    {
        return $this->jwtAuth->manager()->getPayloadFactory();
    }

    public function getClaimsFactory()
    {
        return $this->jwtAuth->manager()->getClaimsFactory();
    }

    public function getJWTProvider()
    {
        return $this->jwtAuth->manager()->getJWTProvider();
    }

    public function getJWTFactory()
    {
        return $this->jwtAuth->manager()->getJWTFactory();
    }

    public function getJWT()
    {
        return $this->jwtAuth->manager()->getJWT();
    }

    public function getParser()
    {
        return $this->jwtAuth->manager()->getParser();
    }

    public function getValidator()
    {
        return $this->jwtAuth->manager()->getValidator();
    }

    public function getPayloadValidator()
    {
        return $this->jwtAuth->manager()->getPayloadValidator();
    }

    public function getClaimsValidator()
    {
        return $this->jwtAuth->manager()->getClaimsValidator();
    }

    public function getRequiredClaims()
    {
        return $this->jwtAuth->manager()->getRequiredClaims();
    }

    public function getTTL()
    {
        return $this->jwtAuth->manager()->getTTL();
    }

    public function setTTL($ttl)
    {
        $this->jwtAuth->manager()->setTTL($ttl);
    }

}