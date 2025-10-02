<?php

namespace App\Services;

/**
 * LDAP Authentication Service
 * 
 * This service handles all LDAP-related operations:
 * 1. Authentication (bind) with LDAP server
 * 2. User information retrieval from LDAP directory
 * 3. Role mapping from LDAP groups
 * 
 * Future Implementation Notes:
 * - Will use PHP's LDAP extension (php_ldap)
 * - Requires LDAP server details (host, port, base DN)
 * - User attributes will be mapped from LDAP fields
 * - Groups will be mapped to roles
 */
class LdapAuthenticationService
{
    /**
     * Demo credentials (to be removed)
     * Replace with LDAP configuration:
     * - LDAP_HOST: ldap://your-server:389
     * - BASE_DN: dc=example,dc=com
     * - BIND_DN: cn=admin,dc=example,dc=com
     */
    private const DEMO_USER = [
        'username' => 'admin',
        'password' => 'password123',
        'name' => 'System Admin',
        'role' => 'super_admin'
    ];

    /**
     * Authenticate user against LDAP server
     * 
     * Future Implementation Steps:
     * 1. Connect to LDAP server using configured host/port
     * 2. Bind with service account (if required)
     * 3. Search for user by username/email
     * 4. Attempt bind with user credentials
     * 5. If successful, fetch user details and groups
     * 
     * @param string $username User's login name
     * @param string $password User's password
     * @return array|null User data if authenticated, null if failed
     */
    public function authenticate(string $username, string $password): ?array
    {
        if ($username === self::DEMO_USER['username'] && 
            $password === self::DEMO_USER['password']) {
            return self::DEMO_USER;
        }
        return null;
    }
}