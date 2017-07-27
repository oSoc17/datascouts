/**
 * Service to handle the storage process of the Entity or Handle.
 *
 */


const localStorage = window.localStorage;
const KEY_FOR_TOKEN = 'RNBj6SdRylyGssMk7dEYyUfRR2JPF2BU';

const KEY_FOR_LAST_ENTITY     = 'LAST_ENTITY';
const KEY_FOR_CURRENT_ENTITY  = 'CURRENT_ENTITY';
const KEY_FOR_ACTIVE_ENTITIES = 'ACTIVE_ENTITIES';

const KEY_FOR_LAST_HANDLE    = 'LAST_HANDLES_FOR_ENTITY_';
const KEY_FOR_ACTIVE_HANDLES = 'ACTIVE_HANDLE_FOR_ENTITY_';
const KEY_FOR_CURRENT_HANDLE = 'CURRENT_HANDLES';


 /**
  * ENTITIES
  *
  */

/**
 * Same process to cache/retrieve some object into/from the localStorage
 *
 */
const marshall = (key, value) => localStorage.setItem(key, JSON.stringify(value))

const unmarshall = (key) => JSON.parse(localStorage.getItem(key))

const remove = (key) => localStorage.removeItem(key)



 /**
  * ENTITIES
  *
  */

export const saveCurrentEntity = v => marshall(KEY_FOR_CURRENT_ENTITY, v)

export const getCurrentEntity = _ => unmarshall(KEY_FOR_CURRENT_ENTITY)

export const removeCurrentEntity = _ => remove(KEY_FOR_CURRENT_ENTITY)


export const setLastEntity = v => marshall(KEY_FOR_LAST_ENTITY, v)

export const getLastEntity = _ => unmarshall(KEY_FOR_LAST_ENTITY)

export const removeLastEntity = _ => remove(KEY_FOR_LAST_ENTITY)


export const saveActiveEntities = l => marshall(KEY_FOR_ACTIVE_ENTITIES, l)

export const getActiveEntities = _ => unmarshall(KEY_FOR_ACTIVE_ENTITIES) || []

export const removeActiveEntity = k => remove(KEY_FOR_ACTIVE_ENTITIES)


 /**
  * HANDLES
  * The entity ID is required for the last/actives Handle function.
  */

export const saveCurrentHandle = (handle) => {
    return marshall(KEY_FOR_CURRENT_HANDLE, handle)
}

export const getCurrentHandle = _ => unmarshall(KEY_FOR_CURRENT_HANDLE)

export const removeCurrentHandle = _ => unmarshall(KEY_FOR_CURRENT_HANDLE)


export const setLastHandle = (id, h) => marshall(KEY_FOR_LAST_HANDLE + id, h)

export const getLastHandle = id => unmarshall(KEY_FOR_LAST_HANDLE + id)

export const removeLastHandle = id => remove(KEY_FOR_LAST_HANDLE + id)


export const saveActiveHandles = (id, list) => {
    return marshall(KEY_FOR_ACTIVE_HANDLES + id, list)
}

export const getActiveHandles = id => unmarshall(KEY_FOR_ACTIVE_HANDLES + id) || []

export const removeActiveHandles = id => remove(KEY_FOR_ACTIVE_HANDLES + id)
