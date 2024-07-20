<?php

namespace App\Models;

use App\Enums\VendorStatus;
use App\Mail\NewVendorAccountRegistered;
use App\Mail\VendorAccountRejected;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;
use LaravelJsonColumn\Traits\JsonColumn;

class VendorRequest extends Model
{
    use HasFactory;
    use JsonColumn;

    protected $fillable = [
        'user_id',
        'rejected_reason',
        'status',
        'extra_data',
    ];

    /**
     * @var array<string,string>
     */
    protected $casts = [
        'extra_data' => 'array',
        'status' => VendorStatus::class,
    ];

    public function scopePending(Builder $builder): Builder
    {
        return $builder->where('status', VendorStatus::Pending);
    }

    public function scopeRejected(Builder $builder): Builder
    {
        return $builder->where('status', VendorStatus::Rejected);
    }

    public function scopeApproved(Builder $builder): Builder
    {
        return $builder->where('status', VendorStatus::Approved);
    }

    public function setStatus(VendorStatus $status): self
    {
        $this->update([
            'status' => $status,
        ]);

        return $this;
    }

    public function approveRequest(): self
    {
        return $this->setStatus(VendorStatus::Approved);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rejectWithReason(string $reason): self
    {
        $this->update([
            'status' => VendorStatus::Rejected,
            'rejected_reason' => $reason,
        ]);

        try {
            Mail::send(new VendorAccountRejected($this->user, $reason));
        } catch (\Exception $exception) {
            session()->flash('error', 'Error'.$exception->getMessage());
        }

        return $this;
    }

    public function makeVendor(): Vendor
    {
        $extraData = $this->getExtraDataArrayAttribute();

        $vendor = Vendor::create([
            'id' => $this->user_id,
            'bio' => optional($extraData)['bio'],
            'vendor_name' => optional($extraData)['vendor_name'],
            'company_name' => optional($extraData)['company_name'],
            'company_address_components' => optional($extraData)['company_address_components'] ?? [],
            'company_phone' => optional($extraData)['company_phone'],
            'is_active' => true,
        ]);

        try {
            Mail::send(new NewVendorAccountRegistered($vendor->user));
        } catch (\Exception $exception) {
            session()->flash('error', 'Error'.$exception->getMessage());
        }

        return $vendor;
    }
}
