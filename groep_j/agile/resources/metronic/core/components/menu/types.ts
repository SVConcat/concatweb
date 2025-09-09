import { Placement } from "@popperjs/core";

export declare type KTMenuItemToggleType = 'dropdown' | 'accordion';

export declare type KTMenuItemTriggerType = 'hover' | 'click';

export interface KTMenuConfigInterface {
	dropdownZindex: string,
	dropdownHoverTimeout: number,
	dropdownPlacement: Placement;
	dropdownOffset: string;
  accordionExpandAll: boolean,
}

export interface KTMenuInterface {		
	disable(): void;
	enable(): void;
	update(): void;
}