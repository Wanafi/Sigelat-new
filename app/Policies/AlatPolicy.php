<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Alat;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlatPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Alat');
    }

    public function view(AuthUser $authUser, Alat $alat): bool
    {
        return $authUser->can('View:Alat');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Alat');
    }

    public function update(AuthUser $authUser, Alat $alat): bool
    {
        return $authUser->can('Update:Alat');
    }

    public function delete(AuthUser $authUser, Alat $alat): bool
    {
        return $authUser->can('Delete:Alat');
    }

    public function restore(AuthUser $authUser, Alat $alat): bool
    {
        return $authUser->can('Restore:Alat');
    }

    public function forceDelete(AuthUser $authUser, Alat $alat): bool
    {
        return $authUser->can('ForceDelete:Alat');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Alat');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Alat');
    }

    public function replicate(AuthUser $authUser, Alat $alat): bool
    {
        return $authUser->can('Replicate:Alat');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Alat');
    }

}