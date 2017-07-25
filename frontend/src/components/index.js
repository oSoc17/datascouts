import { bus } from '../main'

/**
 * SIDEBARS
 */
import entitiesSidebar  from './sidebars/entitiesSidebar.vue'
import handlesSidebar  from './sidebars/handlesSidebar.vue'
// export { EntitiesSidebar } from './EntitiesSidebar.vue'


/**
 * COMPONENTS
 */
import flashMessage from './flashMessage.vue'

import entitiesList from './entities/entitiesList.vue'
import editEntity from './entities/editEntity.vue'
import addEntity from './entities/addEntity.vue'

import handlesList from './handles/handlesList.vue'
import addHandle from './handles/addHandle.vue'
import editHandle from './handles/editHandle.vue'

//import fetchResults from './results/fetchResultList.vue'
import waterfallDisplay from './results/waterfallDisplay.vue'



/**
 * PARTIALS
 *
 */






/**
 * EXPORTS
 *
 */

// List of compenents with the corresponding tag for it.
export const Components = {

    'sidebars' : {
        entitiesSidebar,
        handlesSidebar
    },

    'entities' : {
        entitiesList,
        addEntity,
        editEntity
    },

    'handles' : {
        handlesList,
        addHandle,
        editHandle
    },

    'flashMsg' : flashMessage

    'results' : {
        //fetchResults,
        waterfallDisplay
    }

}



// Each components, in-case
export {
    bus,

    // entitiesSidebar,
    // handlesSidebar,

    // entitiesList,
    // addEntity,
    // editEntity,

    // handlesList,
    // addHandle,
    // editHandle,
    // fetchResults
}
