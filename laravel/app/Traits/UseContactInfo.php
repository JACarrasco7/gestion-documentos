<?php
namespace App\Traits;

use App\Models\ContactInfo;

trait UseContactInfo
{
    public function contact_info()
    {
        return $this->belongsTo(ContactInfo::class);
    }

    public function getFullAddress(): string
    {
        return $this->contact_info->province . ', ' . $this->contact_info->city . '' . ' (' . $this->contact_info->postal_code . ') ' . $this->contact_info->address;
    }
}