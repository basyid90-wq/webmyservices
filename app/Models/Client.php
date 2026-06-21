<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'website',
        'logo',
        'address',
        'notes',
        'pic_name',
        'website_type',
        'domain_name',
        'domain_provider_url',
        'domain_login',
        'domain_password',
        'domain_price_cost',
        'domain_price_sell',
        'domain_start_date',
        'domain_expiry_date',
        'hosting_name',
        'hosting_provider_url',
        'hosting_login',
        'hosting_password',
        'hosting_price_cost',
        'hosting_price_sell',
        'hosting_start_date',
        'hosting_expiry_date',
        'wp_login',
        'wp_password',
        'wp_last_plugin_update',
        'status_renew',
        'is_subscription_active',
    ];

    protected function casts(): array
    {
        return [
            'domain_start_date' => 'date',
            'domain_expiry_date' => 'date',
            'hosting_start_date' => 'date',
            'hosting_expiry_date' => 'date',
            'wp_last_plugin_update' => 'date',
            'is_subscription_active' => 'boolean',
        ];
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function plugins()
    {
        return $this->hasMany(Plugin::class);
    }

    public function getBakiDomainAttribute(): ?int
    {
        if (!$this->domain_expiry_date) {
            return null;
        }

        return (int) Carbon::parse($this->domain_expiry_date)->diffInDays(now(), false);
    }

    public function getBakiHostingAttribute(): ?int
    {
        if (!$this->hosting_expiry_date) {
            return null;
        }

        return (int) Carbon::parse($this->hosting_expiry_date)->diffInDays(now(), false);
    }

    public function getIsDomainCriticalAttribute(): bool
    {
        if ($this->baki_domain === null || $this->status_renew === 'sudah_renew') {
            return false;
        }

        return $this->baki_domain <= 45;
    }

    public function getIsDomainWarningAttribute(): bool
    {
        if ($this->baki_domain === null || $this->status_renew === 'sudah_renew') {
            return false;
        }

        return $this->baki_domain <= 60;
    }

    public function getIsWpOverdueAttribute(): bool
    {
        if (!$this->wp_last_plugin_update) {
            return false;
        }

        return Carbon::parse($this->wp_last_plugin_update)->diffInDays(now()) >= 40;
    }
}
