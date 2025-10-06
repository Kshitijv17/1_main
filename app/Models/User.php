<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_guest',
        'expires_at',
        'role',
        'phone',
        'date_of_birth',
        'address',
        'phone_verified_at',
        'email_verified_at',
        'guest_session_id',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'expires_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'is_guest' => 'boolean',
        'role' => UserRole::class,
    ];

    /**
     * Check if the user is a guest
     */
    public function isGuest(): bool
    {
        return $this->role === UserRole::GUEST;
    }

    /**
     * Check if the user is a user
     */
    public function isUser(): bool
    {
        return $this->role === UserRole::USER;
    }

    /**
     * Check if the user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    /**
     * Check if the user is a vendor
     */
    public function isVendor(): bool
    {
        return $this->role === UserRole::VENDOR;
    }

    /**
     * Get the user's role display name
     */
    public function getRoleDisplayAttribute(): string
    {
        return $this->role->getDisplayName();
    }

    /**
     * Get the user's role badge color
     */
    public function getRoleBadgeColorAttribute(): string
    {
        return $this->role->getBadgeColor();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission($permission): bool
    {
        // Admins have all permissions
        if ($this->isAdmin()) {
            return true;
        }

        // Vendors have vendor-specific permissions by default
        if ($this->isVendor()) {
            $vendorPermissions = ['manage_shop', 'manage_products', 'manage_orders', 'view_analytics'];
            if (in_array($permission, $vendorPermissions)) {
                return true;
            }
        }

        // Check specific permissions for regular users
        return $this->permissions()->where('name', $permission)->exists();
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        // Admins have all permissions
        if ($this->isAdmin()) {
            return true;
        }

        // Vendors have vendor-specific permissions by default
        if ($this->isVendor()) {
            $vendorPermissions = ['manage_shop', 'manage_products', 'manage_orders', 'view_analytics'];
            if (array_intersect($permissions, $vendorPermissions)) {
                return true;
            }
        }

        // Check if user has any of the specified permissions
        return $this->permissions()->whereIn('name', $permissions)->exists();
    }

    /**
     * Assign permissions to user
     */
    public function assignPermissions(array $permissions)
    {
        $permissionIds = Permission::whereIn('name', $permissions)->pluck('id');
        $this->permissions()->sync($permissionIds);
    }

    /**
     * Get user's permissions as array
     */
    public function getPermissionsArray(): array
    {
        return $this->permissions->pluck('name')->toArray();
    }

    /**
     * Orders relationship
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Shop relationship (for vendor users)
     */
    public function shop()
    {
        return $this->hasOne(Shop::class, 'vendor_id');
    }

    /**
     * Get user's shop products (for vendor users)
     */
    public function shopProducts()
    {
        if (!$this->isVendor()) {
            return collect();
        }
        
        return $this->shop ? $this->shop->products : collect();
    }

    /**
     * Get user's shop orders (for vendor users)
     */
    public function shopOrders()
    {
        if (!$this->isVendor()) {
            return collect();
        }
        
        return $this->shop ? $this->shop->orders : collect();
    }

    /**
     * Get user's wishlist items
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get user's wishlist products
     */
    public function wishlistProducts()
    {
        return $this->belongsToMany(Product::class, 'wishlists')->withTimestamps();
    }

    /**
     * Check if product is in user's wishlist
     */
    public function hasInWishlist($productId): bool
    {
        return $this->wishlists()->where('product_id', $productId)->exists();
    }
}
