<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DetailGelar;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetailGelarPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DetailGelar');
    }

    public function view(AuthUser $authUser, DetailGelar $detailGelar): bool
    {
        return $authUser->can('View:DetailGelar');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DetailGelar');
    }

    public function update(AuthUser $authUser, DetailGelar $detailGelar): bool
    {
        return $authUser->can('Update:DetailGelar');
    }

    public function delete(AuthUser $authUser, DetailGelar $detailGelar): bool
    {
        return $authUser->can('Delete:DetailGelar');
    }

    public function restore(AuthUser $authUser, DetailGelar $detailGelar): bool
    {
        return $authUser->can('Restore:DetailGelar');
    }

    public function forceDelete(AuthUser $authUser, DetailGelar $detailGelar): bool
    {
        return $authUser->can('ForceDelete:DetailGelar');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DetailGelar');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DetailGelar');
    }

    public function replicate(AuthUser $authUser, DetailGelar $detailGelar): bool
    {
        return $authUser->can('Replicate:DetailGelar');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DetailGelar');
    }

}