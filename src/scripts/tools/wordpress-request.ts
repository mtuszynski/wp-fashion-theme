declare global {
	namespace NodeJS {
		interface Global {
			ajax_object: {
				ajax_url: string;
				wp_nonce: string;
			};
		}
	}
}

export interface IWordpressRequest {
	action: string;
	dto?: {
		[key: string]: string | number;
	},
	onSuccess?: (data: any) => void;
	onError?: () => void;
}

export async function wordpressRequest<DTO = string, Output = any>(params: IWordpressRequest): Promise<Output> {
	const { action, onError, dto } = params;
	
	const xhr = new XMLHttpRequest();

	return new Promise((resolve, reject) => {
		xhr.open('POST', `${global.ajax_object.ajax_url}?action=${action}`, true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

		xhr.onload = () => {
			if (xhr.status >= 200 && xhr.status < 300) {
				return resolve(xhr.response);
			} else {
				return reject(xhr.statusText);
			}
		};

		xhr.onerror = () => {
			console.error(this);

			if (onError) {
				onError();
			}
		};

		xhr.send(dto ? "json=" + JSON.stringify({
			...dto,
			wp_nonce: global.ajax_object.wp_nonce
		}) : null);
	});
}
