<?php

namespace App\DTO;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Simple DTO for LDAP user data
 * Implements Authenticatable for auth compatibility
 */
class LdapUser implements Authenticatable
{
    private string $name;
    private string $username;
    private string $role;

    public function __construct(array $userData)
    {
        $this->name = $userData['name'];
        $this->username = $userData['username'];
        $this->role = $userData['role'];
    }

    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    public function getAuthIdentifier(): string
    {
        return $this->username;
    }

    public function getAuthPassword(): string
    {
        return '';  // Not storing passwords
    }

    public function getRememberToken(): string
    {
        return '';  // Not using remember tokens
    }

    public function setRememberToken($value): void
    {
        // Not implemented
    }

    public function getRememberTokenName(): string
    {
        return '';  // Not using remember tokens
    }

    // Custom getters
    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}