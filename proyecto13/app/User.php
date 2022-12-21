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
        protected $casts = [
            'active' => 'bool'
        ];
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
        public function getNameAttribute()
        {
            return $this->first_name . ' ' . $this->last_name;
        }

        public function scopeSearch($query, $search)
        {
            if (empty($search)) {
                return;
            }
            $query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhereHas('team', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        }

        public function scopeByState($query, $state)
        {
            if ($state == 'active') {
                return $query->where('active', true);
            }

            if ($state == 'inactive') {
                return $query->where('active', false);
            }
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
