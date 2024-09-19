export class CookiesService {
    public set(name: string, value: string | number | boolean, expiryDate: number) {
        const d = new Date();
        d.setTime(d.getTime() + (expiryDate * 24 * 60 * 60 * 1000));

        document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
    }

    public get(cname: string): string {
        const name = cname + "=";
        const decodedCookie = decodeURIComponent(document.cookie);
        const ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return;
    }
}