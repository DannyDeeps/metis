<?php

namespace Metis\ORM;

use IteratorAggregate;
use Countable;
use ArrayAccess;
use ArrayIterator;

/**
 * EntityCollection
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class EntityCollection implements IteratorAggregate, Countable, ArrayAccess
{

    protected $entities;
    protected $position;

    public function __construct(array $entities= [])
    {
        $this->entities= $entities;
    }

    /**
     * Set the entities in this collection.
     *
     * @return array
     * @return EntityCollection This collection
     */
    public function setEntities(array $entities= [])
    {
        $this->entities= $entities;

        return $this;
    }

    /**
     * Return the entities in this collection.
     *
     * @return array An array of entities
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * Return the entities in this collection, split into chunks.
     *
     * @param  int   $size The size of each chunk
     * @return array An array of entities
     */
    public function chunk($chunk)
    {
        return array_chunk($this->entities, $chunk);
    }

    /**
     * Set the value of a column for all entities in this
     * collection. Setter methods will be called.
     *
     * @param  string           $name  The name of the column
     * @param  mixed            $value The value
     * @return EntityCollection This collection
     */
    public function setColumn($name, $value)
    {
        foreach ($this->entities as $entity)
        {
            $entity->_set($name, $value);
        }

        return $this;
    }

    /**
     * Set the value of a column for all entities in this
     * collection. Setter methods will not be called.
     *
     * @param  string           $name  The name of the column
     * @param  mixed            $value The value
     * @return EntityCollection This collection
     */
    // public function setColumnRaw($name, $value)
    // {
    //     foreach ($this->entities as $entity) {
    //         $entity->setRaw($name, $value);
    //     }

    //     return $this;
    // }

    /**
     * Get the values of a single column from all entities in this
     * collection. Getter methods will be called.
     *
     * @param  string $name The name of the column
     * @return array  A list of values
     */
    public function getColumn($name)
    {
        $results= [];
        foreach ($this->entities as $entity) {
            $results[]= $entity->_get($name);
        }

        return $results;
    }

    /**
     * Get the values of a single column from all entities in this
     * collection. Getter methods will not be called.
     *
     * @param  string $name The name of the column
     * @return array  A list of values
     */
    // public function getColumnRaw($name)
    // {
    //     $results= [];
    //     foreach ($this->entities as $entity) {
    //         $results[]= $entity->getRaw($name);
    //     }

    //     return $results;
    // }

    /**
     * Get a single Entity from this collection where column =
     * value. If more than one Entity is matched, the first will be
     * returned. If no Entity is matched, null will be returned.
     *
     * @param  string $column
     * @param  string $value
     * @param  bool   $strict use strict comparison when comparing values
     * @return mixed  Entity or NULL
     */
    public function getOne($column, $value, $strict= true)
    {
        if ($strict) {
            foreach ($this->entities as $entity) {
                if ($entity->_get($column) === $value) {
                    return $entity;
                }
            }
        } else {
            foreach ($this->entities as $entity) {
                if ($entity->_get($column) == $value) {
                    return $entity;
                }
            }
        }

        return;
    }

    /**
     * Get a random Entity from this collection, or null if the
     * collection is empty.
     *
     * @return Entity|null
     */
    public function getRandom()
    {
        return empty($this->entities) ? null : $this->entities[array_rand($this->entities)];
    }

    /**
     * Remove a single Entity from this collection where column =
     * value. If more than one Entity is matched, the first will be
     * removed and returned. If no Entity is matched, null will be
     * returned.
     *
     * @param  string $column
     * @param  string $value
     * @return mixed  The removed Entity or NULL
     */
    public function remove($column, $value)
    {
        foreach ($this->entities as $index => $entity) {
            if ($entity->get($column) === $value) {
                //remove the entity and reset the keys
                unset($this->entities[$index]);
                $this->entities= array_values($this->entities);

                return $entity;
            }
        }

        return;
    }

    /**
     * Remove a random Entity from this collection, or null if the
     * collection is empty.
     *
     * @return Entity|null
     */
    public function removeRandom()
    {
        $index= array_rand($this->entities);
        $entity= $this->entities[$index];
        unset($this->entities[$index]);

        return $entity;
    }

    /**
     * Filter entities from this collection using a callback function. Return true in the callback to keep the entity.
     *
     * @param  \Closure         $callback The callback function
     * @return EntityCollection A new EntityCollection with the filtered entities.
     */
    public function filter(\Closure $callback)
    {
        return new static(array_values(array_filter($this->entities, $callback)));
    }

    /**
     * Save all the entities in this collection.
     *
     * @return EntityCollection This collection
     */
    public function save()
    {
        foreach ($this->entities as $entity) {
            $entity->save();
        }

        return $this;
    }

    /**
     * Delete all entities in this collection.
     *
     * @return EntityCollection This collection
     */
    public function delete()
    {
        foreach ($this->entities as $entity) {
            $entity->delete();
        }

        return $this;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->entities);
    }

    public function count()
    {
        return count($this->entities);
    }

    public function offsetGet($offset)
    {
        return isset($this->entities[$offset]) ? $this->entities[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (!is_int($offset) && !is_null($offset)) {
            throw new \InvalidArgumentException('Non numeric keys for EntityCollection are forbidden.');
        }
        if (is_null($offset)) {
            $this->entities[]= $value;
        } else {
            $this->entities[$offset]= $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->entities[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->entities[$offset]);
    }
}