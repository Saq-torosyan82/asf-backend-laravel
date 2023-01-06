<?php

namespace App\Containers\AppSection\User\Models;

use App\Containers\AppSection\Authentication\Traits\AuthenticationTrait;
use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\Authorization\Traits\AuthorizationTrait;
use App\Containers\AppSection\Notification\Models\NotificationsLogs;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Models\SocialMediaFollowers;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\UserSponsorship\Models\UserSponsorship;
use App\Ship\Parents\Models\UserModel;
use Illuminate\Notifications\Notifiable;

class User extends UserModel
{
    use Notifiable;

    use AuthorizationTrait;
    use AuthenticationTrait;
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'device',
        'platform',
        'gender',
        'birth',
        'social_provider',
        'social_token',
        'social_refresh_token',
        'social_expires_in',
        'social_token_secret',
        'social_id',
        'social_avatar',
        'social_avatar_original',
        'social_nickname',
        'email_verified_at',
        'is_active',
        'is_locked',
        'is_admin',
        'login_token',
        'login_token_expire',
        'parent_id',
        'extra_data'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
        'is_locked' => 'boolean',
        'email_verified_at' => 'datetime',
        'login_token_expire' => 'datetime'
    ];

    public function UserProfile() {
        return $this->hasMany(\App\Containers\AppSection\UserProfile\Models\UserProfile::class);
    }

    public function sponsorships($type) {
        return $this->hasMany(UserSponsorship::class)->where('type', $type);
    }

    public function FindUserRoleByName(string $roleName): ?Role {
        return $this->roles->where('name', $roleName)->first();
    }

    public function notificationsLogs() {
        return $this->morphMany(NotificationsLogs::class, 'entity', 'entity_type');
    }

    public function Parent() {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function childs() {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function athletes() {
        return $this->hasMany(User::class, 'parent_id')->whereHas('UserProfile', function($query){
            $query->where('group', Group::ACCOUNT);
            $query->where('key', Key::BORROWER_TYPE);
            $query->where('value', BorrowerType::ATHLETE);
        });
    }

    public function scopeGetAgent($query) {
        return $query->with('UserProfile')->whereHas('UserProfile', function($query){
            $query->where('group', Group::ACCOUNT);
            $query->where('key', Key::BORROWER_TYPE);
            $query->where('value', BorrowerType::ATHLETE);
        });
    }

    public function agents() {
        return $this->hasMany(User::class, 'parent_id')
            ->where('is_active', 1)->whereHas('UserProfile', function($query){
            $query->where('group', Group::ACCOUNT);
            $query->where('key', Key::BORROWER_TYPE);
            $query->where('value', BorrowerType::AGENT);
        });
    }

    public function BorrowerType() {
        return app(GetBorrowerTypeTask::class)->run($this->id);
    }

    public function socialMediaFollowers() {
        return $this->hasMany(SocialMediaFollowers::class, 'user_id', 'id');
    }

    public function isAthlete() {
        $borrowerType = $this->BorrowerType();
        if ($borrowerType == null) {
            return false;
        }
        return $borrowerType == BorrowerType::ATHLETE;
    }

    public function isAgent() {
        $borrowerType = $this->BorrowerType();
        if ($borrowerType == null) {
            return false;
        }
        return $borrowerType == BorrowerType::AGENT;
    }

    public function isIndependentAgent()
    {
        return $this->isAgent() && !$this->agents()->count();
    }

    /**
     * @return bool
     * @return bool
     */
    public function isCorporate() {
        $borrowerType = $this->BorrowerType();
        if ($borrowerType == null) {
            return false;
        }
        return $borrowerType == BorrowerType::CORPORATE;
    }

    public function isLender()
    {
        return $this->FindUserRoleByName(PermissionType::LENDER);
    }

    public function isBorrower()
    {
        return $this->FindUserRoleByName(PermissionType::BORROWER);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function admins($query) {
        $query->where('is_admin', 1);
    }

    public function routeNotificationForMail($notification)
    {
        return [$this->email => $this->first_name];
    }

    public function isAgency()
    {
        return $this->isAgent() && ($this->agents()->count() > 0);
    }

    public function isAthleteWithAgent() {
        return $this->isAthlete() && $this->parent_id;
    }
}
