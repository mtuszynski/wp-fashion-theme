import { body, html } from "../../tools/element";
import { easeInOutQuad } from "../../tools/transition";
import { BrowserScrollTo, IBrowserScrollTo } from "./browser-scroll-to";

type TScroll = {
  top: number;
  bottom: number;
  center: number;
  speed: number;
  direction: string;
}

export class BrowserService {
  private browserScrollTo: BrowserScrollTo;

  public scroll: TScroll;
  public width: number;
  public height: number;
  public documentHeight: number;

  constructor() {
    window.addEventListener("resize", () => this.onResize(), false);
    window.addEventListener("scroll", () => this.onScroll(), false);

    this.onResize();
    this.onScroll();
  }

  protected onResize() {
    this.width = window.innerWidth;
    this.height = window.innerHeight;

    this.documentHeight = Math.max(
      body.scrollHeight,
      body.offsetHeight,
      html.clientHeight,
      html.scrollHeight,
      html.offsetHeight
    );
  }

  protected onScroll() {
    /* Check last center */
    let lastTop = 0;
    if (this.scroll) {
      lastTop = this.scroll.top;
    }

    /* Prepare variables */
    let direction: string;
    let top = window.pageYOffset || html.scrollTop || document.documentElement.scrollTop;

    /* Check scroll direction */
    if (top < lastTop) {
      direction = "up";
    } else {
      direction = "down";
    }

    this.scroll = {
      top,
      bottom: top + this.height,
      center: top + (this.height / 2),
      speed: Math.abs(lastTop - top),
      direction
    };
  }

  /**
   * Scroll browser to html element
   * @param params Scroll parameters
   */
  public scrollTo(params: IBrowserScrollTo) {
    if (this.browserScrollTo && this.browserScrollTo.isActive) {
      this.browserScrollTo.destroy();
    }

    this.browserScrollTo = new BrowserScrollTo(params);
  }
}