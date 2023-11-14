import Vue from 'vue';
import VueRouter from 'vue-router';

import InventoryCategories from '../inventory/Categories.vue';
import InventoryItems from '../inventory/Items.vue';
import InventoryItem from '../inventory/Item.vue';
import InventoryItemTypes from '../inventory/ItemTypes.vue';
import InventoryStores from '../inventory/Stores.vue';
import InventoryStore from '../inventory/Store.vue';
import InventoryPurchaseOrders from '../inventory/PurchaseOrders.vue';
import InventoryTransferOrders from '../inventory/TransferOrders.vue';
import InventoryTransferOrdersInt from '../inventory/TransferOrdersInt.vue';

import InventoryDetailTransferOrder from '../inventory/details/TransferOrder.vue';

import InventoryFormItem from '../inventory/forms/Item.vue';
import InventoryFormItemType from '../inventory/forms/ItemType.vue';
import InventoryFormStore from '../inventory/forms/Store.vue';
import InventoryFormTransferOrder from '../inventory/forms/TransferOrder.vue';
import InventoryFormCategory from '../inventory/forms/Category.vue';

Vue.component('InventoryCategories',    InventoryCategories);
Vue.component('InventoryItems',         InventoryItems);
Vue.component('InventoryItem',          InventoryItem);
Vue.component('InventoryItemTypes',     InventoryItemTypes);
Vue.component('InventoryStores',        InventoryStores);
Vue.component('InventoryStore',         InventoryStore);

Vue.component('InventoryDetailTransferOrder',       InventoryDetailTransferOrder);

Vue.component('InventoryTransferOrders', InventoryTransferOrders);
Vue.component('InventoryTransferOrdersInt', InventoryTransferOrdersInt);

Vue.component('InventoryFormItem',          InventoryFormItem);
Vue.component('InventoryFormItemType',      InventoryFormItemType);
Vue.component('InventoryFormStore',         InventoryFormStore);
Vue.component('InventoryFormTransferOrder', InventoryFormTransferOrder);
Vue.component('InventoryFormCategory',      InventoryFormCategory);

let routes = [
    { path: '/inventory/categories',                component: InventoryCategories },
    { path: '/inventory/item_types',                component: InventoryItemTypes },

    { path: '/inventory/items',                     component: InventoryItems },
    { path: '/inventory/items/:id',                 component: InventoryItem },

    { path: '/inventory/stores',                    component: InventoryStores },
    { path: '/inventory/stores/:id',                component: InventoryStore },

    { path: '/inventory/purchase_orders',           component: InventoryPurchaseOrders },

    { path: '/inventory/transfer_orders',           component: InventoryTransferOrders },
    { path: '/inventory/transfer_orders/int',       component: InventoryTransferOrdersInt},
    { path: '/inventory/transfer_orders/new',       component: InventoryFormTransferOrder},
    //{ path: '/inventory/transfer_orders/merge',     component: InventoryFormTransferOrderMerge},

];


export default routes                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 