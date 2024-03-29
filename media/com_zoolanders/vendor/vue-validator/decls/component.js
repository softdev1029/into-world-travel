/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

// TODO: should be provided from vue.js 
declare type VNode = {}
declare type Watcher = {}
declare type Config = {
  [key: string]: any
}

declare interface Component {
  // constructor information
  static cid: number;
  static options: Object;
  // extend
  static extend: (options: Object) => Function;
  static superOptions: Object;
  static extendOptions: Object;
  static super: Class<Component>;
  // assets
  static directive: (id: string, def?: Function | Object) => Function | Object | void;
  static component: (id: string, def?: Class<Component> | Object) => Class<Component>;
  static filter: (id: string, def?: Function) => Function | void;

  // public properties
  $el: any; // so that we can attach __vue__ to it
  $data: Object;
  $options: ComponentOptions;
  $parent: Component | void;
  $root: Component;
  $children: Array<Component>;
  $refs: { [key: string]: Component | Element | Array<Component | Element> | void };
  $slots: { [key: string]: Array<VNode> };
  $vnode: VNode;
  $isServer: boolean;

  // public methods
  $mount: (el?: Element | string, hydrating?: boolean) => Component;
  $forceUpdate: () => void;
  $destroy: () => void;
  $watch: (expOrFn: string | Function, cb: Function, options?: Object) => Function;
  $on: (event: string, fn: Function) => Component;
  $once: (event: string, fn: Function) => Component;
  $off: (event?: string, fn?: Function) => Component;
  $emit: (event: string, ...args: Array<any>) => Component;
  $nextTick: (fn: Function) => void;
  $createElement: (
    tag?: string | Component,
    data?: Object,
    children?: VNodeChildren,
    namespace?: string
  ) => VNode;

  /*
   * NOTE: should not be published internal interface ...
   *
  // private properties
  _uid: number;
  _isVue: true;
  _self: Component;
  _renderProxy: Component;
  _renderParent: ?Component;
  _watcher: Watcher;
  _watchers: Array<Watcher>;
  _data: Object;
  _events: Object;
  _inactive: boolean;
  _isMounted: boolean;
  _isDestroyed: boolean;
  _isBeingDestroyed: boolean;
  _vnode: ?VNode;
  _staticTrees: ?Array<VNode>;

  // private methods
  // lifecycle
  _init: Function;
  _mount: (el?: Element | void, hydrating?: boolean) => Component;
  _update: (vnode: VNode, hydrating?: boolean) => void;
  _updateListeners: (listeners: Object, oldListeners: ?Object) => void;
  _updateFromParent: (
    propsData: ?Object,
    listeners: ?{ [key: string]: Function | Array<Function> },
    parentVnode: VNode,
    renderChildren: ?VNodeChildren
  ) => void;
  // rendering
  _render: () => VNode;
  __patch__: (a: Element | VNode | void, b: VNode) => any;
  // renderElementWithChildren
  _h: (
    vnode?: VNode,
    children?: VNodeChildren
  ) => VNode | void;
  // renderElement
  _e: (
    tag?: string | Component | Object,
    data?: Object,
    namespace?: string
  ) => VNode | void;
  // renderStaticTree
  _m: (
    index?: number
  ) => Object | void;
  // toString
  _s: (value: any) => string;
  // toNumber
  _n: (value: string) => number | string;
  // resolveFilter
  _f: (id: string) => Function;
  // renderList
  _l: (
    val: any,
    render: Function
  ) => ?Array<VNode>;
  // apply v-bind object
  _b: (vnode: VNodeWithData, value: any) => void;
  // retrive custom keyCode
  _k: (key: string) => ?number;
  */

  // allow dynamic method registration
  [key: string]: any
}
