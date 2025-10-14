<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Mobil;
use Illuminate\Auth\Access\HandlesAuthorization;

class MobilPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Mobil');
    }

    public function view(AuthUser $authUser, Mobil $mobil): bool
    {
        return $authUser->can('View:Mobil');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Mobil');
    }

    public function update(AuthUser $authUser, Mobil $mobil): bool
    {
        return $authUser->can('Update:Mobil');
    }

    public function delete(AuthUser $authUser, Mobil $mobil): bool
    {
        return $authUser->can('Delete:Mobil');
    }

    public function restore(AuthUser $authUser, Mobil $mobil): bool
    {
        return $authUser->can('Restore:Mobil');
    }

    public function forceDelete(AuthUser $authUser, Mobil $mobil): bool
    {
        return $authUser->can('ForceDelete:Mobil');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Mobil');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Mobil');
    }

    public function replicate(AuthUser $authUser, Mobil $mobil): bool
    {
        return $authUser->can('Replicate:Mobil');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Mobil');
    }

}