import { getElement, getElements } from "./DOM";

export interface IComponentConfig {
	element: HTMLElement;
}

export abstract class Component<Constructor = IComponentConfig, Params = any> {
	public element: HTMLElement;

	private readonly _scrollEvent: EventListenerOrEventListenerObject;
	private readonly _resizeEvent: EventListenerOrEventListenerObject;
	private readonly _clicksArray: Array<{
		element: HTMLElement;
		fn: (e?: MouseEvent) => void;
	}> = [];

	protected constructor(config?: Constructor) {
		/* Run function before initialization */
		this.beforeInit && this.beforeInit();

		this.setConfig(config);

		if (!this.element) {
			return
		}

		this.setDataset();

		/* Run function on resize */
		if (this.onResize) {
			window.addEventListener("resize", this._resizeEvent = () => {
				this.onResize();
			},
				false
			);
		}

		/* Run function on scroll */
		if (this.onScroll) {
			window.addEventListener("scroll", this._scrollEvent = () => {
				this.onScroll();
			});
		}

		/* Run initiation function */
		if (this.onInit) {
			this.onInit();
		}

		/* Run function when element is visible */
		if (this.onVisible) {
			const options = {
				root: null,
				rootMargin: '0px',
				threshold: 0.5
			}

			const observer = new IntersectionObserver((entries) => {
				if (!entries[0].isIntersecting) {
					return;
				}

				this.onVisible();

				observer.unobserve(this.element);
			}, options);

			observer.observe(this.element);
		}

		/* Add component to HTMLElement */
		this.element[this.constructor.name] = this;
	}

	/* Parse constructor params */
	protected setConfig(params: Constructor) {
		for (const key in params) {
			if (params.hasOwnProperty(key)) {
				// @ts-ignore
				this[key] = params[key];
			}
		}
	}

	/** Parse element attribute [data-params] */
	protected setDataset() {
		if (!this.element) {
			return
		}

		const dataset = this.element.dataset.params;

		if (!dataset) {
			return;
		}

		const params = JSON.parse(dataset) as Params;

		for (const key in params) {
			if (params.hasOwnProperty(key)) {
				// @ts-ignore
				this[key] = params[key];
			}
		}
	}

	/** Destroy component */
	public destroy() {
		if (this.onDestroy) {
			if (this._scrollEvent) {
				window.addEventListener("scroll", this._scrollEvent);
			}

			if (this._resizeEvent) {
				window.addEventListener("scroll", this._resizeEvent);
			}

			if (this._clicksArray.length) {
				this._clicksArray.map(click => {
					click.element.removeEventListener('click', click.fn);
				})
			}

			this.onDestroy();
		}
	}

	protected getComponentElement<E extends HTMLElement>(value: string): E {
		return getElement(value, this.element);
	};

	protected getComponentElements<E extends HTMLElement>(value: string): NodeListOf<E> {
		return getElements(value, this.element);
	};

	protected setClick(element: HTMLElement, onClickFunction:(params: any) => void, passedParams?: any) {
		let fn: (e: MouseEvent) => void;

		element.addEventListener('click', fn = (e: MouseEvent) => {
			if (passedParams) {
				onClickFunction(passedParams);
			} else {
				onClickFunction(e);
			}
		})

		this._clicksArray.push({
			element, 
			fn
		});
	}

	protected beforeInit?(): void;

	protected onInit?(): void;

	protected onDestroy?(): void;

	protected onVisible?(): void;

	protected onScroll?(): void;

	protected onResize?(): void;
}
