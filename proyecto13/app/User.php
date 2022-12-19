<?php

	namespace App;

	use Illuminate\Database\Eloquent\SoftDeletes;
	use Illuminate\Notifications\Notifiable;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Support\Facades\DB;

	class User extends Authenticatable
	{
		use Notifiable, SoftDeletes;

		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $guarded = [];

		/**
		 * The attributes that should be hidden for arrays.
		 *
		 * @var array
		 */
		protected $hidden = ['password', 'remember_token'];

		public static function findByEmail($email)
		{
			return static::whereEmail($email)->first();
		}

        public function scopeSearch($query, $search)
        {
            if (empty($search)) {
                return;
            }
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('team', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
        }

		public function profile()
		{
			return $this->hasOne(UserProfile::class)->withDefault();
		}

		public function skills()
		{
			return $this->belongsToMany(Skill::class);
		}

		public function team()
		{
			return $this->belongsTo(Team::class)->withDefault();
		}

		public function isAdmin()
		{
			return $this->role === 'admin';
		}
	}
