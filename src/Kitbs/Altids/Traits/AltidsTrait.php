<?php namespace Kitbs\Altids\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Altids;

trait AltidsTrait {

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
	 * Get an instace of the Altids Hashids class using the model's configuration.
	 *
	 * @return \Kitbs\Altids\Altids
	 */
	public function getHashids()
	{
		return Altids::hashids((array) @$this->hashidsConfig);
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

		if ($instance->hasHashid()) {

			$altid = $instance->getHashids()->decrypt($altid);
			
			if (empty($altid)) return null;

			return $instance->find($altid, $columns);

		} elseif ($instance->hasSlug()) {

			return $instance->_chooseWhereSlug($instance->newQuery(), $altid)->get($columns);

		} else {

			return $instance->_chooseWhereIn($instance->newQuery(), $altid)->get($columns);

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

	/**
	 * Spoofs a whereHashid method to allow it to be used in the Query Builder.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @param  mixed $altid
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeWhereHashid($query, $altid)
	{

		if ($this->hasHashid()) {

			$altid = $this->getHashids()->decrypt($altid);

			return $this->_chooseWhereIn($query, $altid);

		}

		return $query->where($this->getKeyName(), null);

	}

	/**
	 * Spoofs a whereSlug method to allow it to be used in the Query Builder.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @param  mixed $slug
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeWhereSlug($query, $slug)
	{

		if ($this->hasSlug()) {

			return $this->_chooseWhereSlug($query, $slug);

		}

		return $query;

	}

	/**
	 * Return the appropriate where clause depending on the value of the Altid.
	 * 
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @param  mixed $altid
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
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

	/**
	 * Return the appropriate where clause depending on the value of the Slug and Disambig, if present.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @param  mixed $slug
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	private function _chooseWhereSlug($query, $slug)
	{

		$slug = $this->_explodeSlug($slug);

		if (!empty($slug['disambig'])) {

			$query->where($this->getDisambigName(), $slug['disambig']);

		}

		return $query->where($this->getSlugName(), $slug['slug']);

	}

	/**
	 * Return an array of the slug and the disambig from a string.
	 * 
	 * @param  mixed  $slug
	 * @return string[]
	 */
	private function _explodeSlug($slug) {
		if (!is_array($slug)) {
			$slug = explode('/', trim($slug, '/'));
		}

		$slug = array_slice(array_pad($slug, 2, null), 0, 2);

		return array_combine(['slug', 'disambig'], $slug);
	}

	/**
	 * Find a model by its Hashid. (Convenience alias of findByAltId()).
	 *
	 * @param  mixed  $hashid
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|Collection|static
	 */
	public static function findByHashid($hashid, $columns = array('*'))
	{
		return static::findByAltId($hashid, $columns);
	}

	/**
	 * Find a model by its Hashid or return new static. (Convenience alias of findByAltIdOrNew()).
	 *
	 * @param  mixed  $hashid
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|Collection|static
	 */
	public static function findByHashidOrNew($hashid, $columns = array('*'))
	{
		return static::findByAltIdOrNew($hashid, $columns);
	}

	/**
	 * Find a model by its Hashid or throw an exception. (Convenience alias of findByAltIdOrFail()).
	 *
	 * @param  mixed  $hashid
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|Collection|static
	 *
	 * @throws ModelNotFoundException
	 */
	public static function findByHashidOrFail($hashid, $columns = array('*'))
	{
		return static::findByAltIdOrFail($hashid, $columns);
	}

	/**
	 * Find a model by its Slug. (Convenience alias of findByAltId()).
	 *
	 * @param  mixed  $slug
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|Collection|static
	 */
	public static function findBySlug($slug, $columns = array('*'))
	{
		return static::findByAltId($slug, $columns);

	}

	/**
	 * Find a model by its Slug or return new static. (Convenience alias of findByAltIdOrNew()).
	 *
	 * @param  mixed  $slug
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|Collection|static
	 */
	public static function findBySlugOrNew($slug, $columns = array('*'))
	{
		return static::findByAltIdOrNew($slug, $columns);
	}

	/**
	 * Find a model by its Slug or throw an exception. (Convenience alias of findByAltIdOrFail()).
	 *
	 * @param  mixed  $slug
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|Collection|static
	 *
	 * @throws ModelNotFoundException
	 */
	public static function findBySlugOrFail($slug, $columns = array('*'))
	{
		return static::findByAltIdOrFail($slug, $columns);
	}
}