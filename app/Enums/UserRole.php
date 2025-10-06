<?php

namespace App\Enums;

enum UserRole: string
{
    case GUEST = 'guest';
    case USER = 'user';
    case VENDOR = 'vendor';
    case ADMIN = 'admin';

    /**
     * Get all role values as an array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get role display name
     */
    public function getDisplayName(): string
    {
        return match($this) {
            self::GUEST => 'Guest',
            self::USER => 'Customer',
            self::VENDOR => 'Vendor',
            self::ADMIN => 'Administrator',
        };
    }

    /**
     * Get role badge color for UI
     */
    public function getBadgeColor(): string
    {
        return match($this) {
            self::GUEST => 'secondary',
            self::USER => 'primary',
            self::VENDOR => 'success',
            self::ADMIN => 'danger',
        };
    }

    /**
     * Get role permissions level (higher number = more permissions)
     */
    public function getPermissionLevel(): int
    {
        return match($this) {
            self::GUEST => 1,
            self::USER => 2,
            self::VENDOR => 3,
            self::ADMIN => 4,
        };
    }

    /**
     * Check if this role has higher or equal permissions than another role
     */
    public function hasPermissionLevel(UserRole $role): bool
    {
        return $this->getPermissionLevel() >= $role->getPermissionLevel();
    }

    /**
     * Get default redirect route for this role
     */
    public function getDefaultRoute(): string
    {
        return match($this) {
            self::GUEST => 'user.home',
            self::USER => 'user.home',
            self::VENDOR => 'vendor.dashboard',
            self::ADMIN => 'admin.dashboard',
        };
    }

    /**
     * Get login route for this role
     */
    public function getLoginRoute(): string
    {
        return match($this) {
            self::GUEST => 'user.login',
            self::USER => 'user.login',
            self::VENDOR => 'vendor.login',
            self::ADMIN => 'admin.login',
        };
    }
}
