/**
 * Service to handle the storage process of the Entity or Handle.
 *
 */


const localStorage = window.localStorage;
const KEY_FOR_TOKEN = 'RNBj6SdRylyGssMk7dEYyUfRR2JPF2BU';

const KEY_FOR_LAST_ENTITY     = 'LAST_ENTITY';
const KEY_FOR_CURRENT_ENTITY  = 'CURRENT_ENTITY';
const KEY_FOR_ACTIVE_ENTITIES = 'ACTIVE_ENTITIES';

const KEY_FOR_LAST_HANDLE    = 'LAST_HANDLES';
const KEY_FOR_ACTIVE_HANDLES = 'ACTIVE_HANDLE';
const KEY_FOR_CURRENT_HANDLE = 'CURRENT_HANDLE';


 /**
  * ENTITIES 
  *
  */


export function saveCurrentEntity(entity) {
    localStorage.setItem(KEY_FOR_CURRENT_ENTITY, JSON.stringify(entity))
}

export function getCurrentEntity() {
    const current = localStorage.getItem(KEY_FOR_CURRENT_ENTITY)
    return JSON.parse(current);
}

export function setLastEntity(entity) {
    localStorage.setItem(KEY_FOR_LAST_ENTITY, JSON.stringify(entity))
}

export function getLastEntity() {
    const last = localStorage.getItem(KEY_FOR_LAST_ENTITY)
    return JSON.parse(last);
}

export function saveActiveEntities(list) {
    localStorage.setItem(KEY_FOR_ACTIVE_ENTITIES, JSON.stringify(list))
}

export function getActiveEntities() {
    const list = localStorage.getItem(KEY_FOR_ACTIVE_ENTITIES)
    return JSON.parse(list) || []
}

 /**
  * HANDLES 
  *
  */

export function saveCurrentHandle(handle,entity_id) {
    localStorage.setItem(KEY_FOR_CURRENT_HANDLE+entity_id, JSON.stringify(handle))
}

export function getCurrentHandle() {
    const current = localStorage.getItem(KEY_FOR_CURRENT_HANDLE)
    return JSON.parse(current);
}

export function setLastHandle(handle) {
    localStorage.setItem(KEY_FOR_LAST_HANDLE, JSON.stringify(handle))
}

export function getLastHandle() {
    const last = localStorage.getItem(KEY_FOR_LAST_HANDLE)
    return JSON.parse(last);
}

export function saveActiveHandles(list, entity_id) {
    localStorage.setItem(KEY_FOR_ACTIVE_HANDLES+entity_id, JSON.stringify(list))
}

export function getActiveHandles(entity_id) {
    const list = localStorage.getItem(KEY_FOR_ACTIVE_HANDLES+entity_id)
    return JSON.parse(list)  || [];
}

