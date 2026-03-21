<?php

namespace App\Traits;

trait ChecksUserType
{
    public function isAdmin(): bool
    {
        return $this->type === 'admin';
    }

    public function isCustomer(): bool
    {
        return $this->type === 'customer';
    }
}
