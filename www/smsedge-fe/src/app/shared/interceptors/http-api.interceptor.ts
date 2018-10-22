import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpInterceptor } from '@angular/common/http';
import { environment } from '../../../environments/environment';

@Injectable()
export class HttpApiInterceptor implements HttpInterceptor {

    constructor() {
    }

    intercept(req: HttpRequest<any>, next: HttpHandler) {
        const apiVersion = environment.apiVersion;

        if (!req.headers.has('Content-Type')) {
            req = req.clone({
                headers: req.headers.append('Content-Type', 'application/vnd.api.' + apiVersion + '+jsonapi; charset=UTF-8')
            });
        }

        req = req.clone({
            headers: req.headers.append('Accept', 'application/vnd.api.' + apiVersion + '+jsonapi')
        });

        return next.handle(req);
    }
}
