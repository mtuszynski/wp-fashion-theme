import { browserService } from "../../main";
import { easeInOutQuad } from "../../tools/transition";

const FRAME_CHANGE = 20;

export type TBrowserScrollToPosition = "top" | "halfTop" | "center" | "bottom";

export interface IBrowserScrollTo {
  element: HTMLElement;
  time?: number;
  offset?: number;
  position?: TBrowserScrollToPosition;
  onDone?: () => void;
  onInterrupt?: () => void;
}

export class BrowserScrollTo implements IBrowserScrollTo {
  public element: HTMLElement;
  public time: number = 1000;
  public offset: number = 0;
  public position: TBrowserScrollToPosition = "halfTop";
  public scrollStartPosition: number;

  public onDone?: () => void;
  public onInterrupt?: () => void;

  private scrollEvent: EventListenerOrEventListenerObject;
  private timeInterval: NodeJS.Timeout;
  private scrollTo: number;
  private currentTime: number = 0;

  public isActive: boolean = true;
  public isInterrupt: boolean = false;

  constructor(config: IBrowserScrollTo) {
    for (const key in config) {
      if (config.hasOwnProperty(key)) {
        this[key] = config[key];
      }
    }

    this.onInit();
  }

  private onInit() {
    this.scrollStartPosition = browserService.scroll.top;

    this.scrollTo =
      this.element.getBoundingClientRect().top -
      this.offset;

    switch (this.position) {
      case "halfTop":
        this.scrollTo -= browserService.height / 4
        break;

      default:
        break;
    }

    document.addEventListener(
      "wheel",
      (this.scrollEvent = () => {
        document.removeEventListener("wheel", this.scrollEvent);
        this.isInterrupt = true;
      })
    );

    this.timeInterval = setInterval(() => {
      if (this.currentTime >= this.time) {
        this.onDestroy();
        this.onDone();

        return;
      }

      if (this.isInterrupt) {
        this.onDestroy();
        this.onInterrupt && this.onInterrupt();

        return;
      }

      if (!this.isActive) {
        this.onDestroy();
      }

      this.currentTime += 20;

      this.runScrollFrame();
    }, FRAME_CHANGE);
  }

  public destroy() {
    this.onDestroy();
  }

  private onDestroy() {
    this.isActive = false;

    clearInterval(this.timeInterval);
    document.removeEventListener("wheel", this.scrollEvent);
  }

  private runScrollFrame() {
    const top = easeInOutQuad(
      this.currentTime,
      this.scrollStartPosition,
      this.scrollTo,
      this.time
    );

    window.scrollTo({ top });
  }
}
