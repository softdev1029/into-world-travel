/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

declare type VNodeChildren = Array<any> | () => Array<any> | string

declare type VNodeComponentOptions = {
  Ctor: Class<Component>,
  propsData: ?Object,
  listeners: ?Object,
  parent: Component,
  children: ?VNodeChildren,
  tag?: string
}

declare interface MountedComponentVNode {
  componentOptions: VNodeComponentOptions;
  child: Component;
  parent: VNode;
  data: VNodeData;
}

// interface for vnodes in update modules
declare interface VNodeWithData {
  tag: string;
  data: VNodeData;
  children: Array<VNode> | void;
  text: void;
  elm: HTMLElement;
  ns: string | void;
  context: Component;
  key: string | number | void;
  parent?: VNodeWithData;
  child?: Component;
}

declare interface VNodeData {
  key?: string | number;
  slot?: string;
  ref?: string;
  tag?: string;
  staticClass?: string;
  class?: any;
  style?: Array<Object> | Object;
  show?: true;
  props?: { [key: string]: any };
  attrs?: { [key: string]: string };
  staticAttrs?: { [key: string]: string };
  hook?: { [key: string]: Function };
  on?: { [key: string]: Function | Array<Function> };
  transition?: Object;
  inlineTemplate?: {
    render: Function,
    staticRenderFns: Array<Function>
  };
  directives?: Array<VNodeDirective>;
  keepAlive?: boolean;
}

declare type VNodeDirective = {
  name: string,
  value?: any,
  oldValue?: any,
  arg?: string,
  modifiers?: { [key: string]: boolean }
}
