<?php namespace Kitbs\Altids\Traits;

use Illuminate\Database\Eloquent\Collection;
use Altids;

trait AltidsTrait {

	private $hashids;
	private $slugs;

	public function getHashids() {

		if (is_null($this->hashids)) {
 			$this->hashids = Altids::hashids((array) @$this->hashidsConfig);
		}

		return $this->hashids;
	}

	/**
	 * Determine if a model uses a Hashid.
	 *
	 * @return bool
	 */
	public function hasHashid()
	{
		return @$this->altid == 'hashid';
	}

	/**
	 * Determine if a model uses a Slug.
	 *
	 * @return bool
	 */
	public function hasSlug()
	{
		return @$this->altid == 'slug';
	}

	/**
	 * Get the Altid (or default to primary key) for the model.
	 *
	 * @return string
	 */
	public function getAltidName()
	{
		if (in_array(@$this->altid, ['hashid', 'slug'])) {
			return @$this->altid;
		}
		return $this->getKeyName();
	}

	/**
	 * Get the value of the model's Altid (if in use).
	 *
	 * @return string
	 */
	public function getAltid()
	{
		if ($this->hasHashid()) {
			return $this->hashid;
		} elseif ($this->hasSlug()) {
			return $this->slug;
		} else {
			return $this->getKey();
		}
	}

	/**
	 * Get the value of the model's Hashid (if in use).
	 *
	 * @return string
	 */
	public function getHashidAttribute()
	{

		if ($this->hasHashid()) {
			var_dump($this->getHashids());
			// return $this->getHashids();
			return $this->getHashids()->encrypt($this->getKey());
		}
	}

	/**
	 * Get the value of the model's Slug (if in use).
	 *
	 * @return string
	 */
	public function getSlugAttribute()
	{
		if ($this->hasSlug()) {
			// ...
			return 'slug';
		}
	}

	/**
	 * Find a model by its Altid.
	 *
	 * @param  mixed  $altid
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|Collection|static
	 */
	public static function findByAltid($altid, $columns = array('*'))
	{
		if (is_array($altid) && empty($altid)) return new Collection;

		$instance = new static;

		$altidName = $instance->getAltidName();

		if ($altidName == 'hashid') {

			$altid = $this->getHashids()->decrypt($altid);
			
			if (empty($altid)) return null;

			return $instance->find($altid, $columns);

		} else {

			return $this->_chooseWhereIn($instance->newQuery(), $altid)->get($columns);

		}

	}

	/**
	 * Find a model by its Altid or return new static.
	 *
	 * @param  mixed  $altid
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|Collection|static
	 */
	public static function findByAltidOrNew($altid, $columns = array('*'))
	{
		if ( ! is_null($model = static::findByAltid($altid, $columns))) return $model;

		return new static($columns);
	}

	/**
	 * Find a model by its Altid or throw an exception.
	 *
	 * @param  mixed  $altid
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|Collection|static
	 *
	 * @throws ModelNotFoundException
	 */
	public static function findByAltidOrFail($altid, $columns = array('*'))
	{
		if ( ! is_null($model = static::findByAltid($altid, $columns))) return $model;

		throw with(new ModelNotFoundException)->setModel(get_called_class());
	}

	public function scopeWhereHashid($query, $altid)
	{

		if ($this->hasHashid()) {

			$altid = $this->getHashids()->decrypt($altid);

			return $this->_chooseWhereIn($query, $altid);

		}

	}

	private function _chooseWhereIn($query, $altid)
	{

		if (is_array($altid)) {

			if (empty($altid)) {

				return $query->where($this->getKeyName(), null);

			} else {

				return $query->whereIn($this->getKeyName(), $altid);
			}

		} else {

			return $query->where($this->getKeyName(), $altid);

		}
	}

}