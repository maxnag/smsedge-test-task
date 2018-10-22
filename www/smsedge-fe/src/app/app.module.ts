import { NgModule } from '@angular/core';
import { BrowserModule } from "@angular/platform-browser";
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { RouterModule } from '@angular/router';
import { CommonModule, LocationStrategy, PathLocationStrategy } from '@angular/common';
import { NgxSpinnerModule } from 'ngx-spinner';
import { AggregatedLogTableModule } from "./modules/aggregated-log/aggregated-log-table.module";

// services
import { HttpApiInterceptor } from './shared/interceptors/http-api.interceptor';

// components
import { AppComponent } from './app.component';

// project routes
import { routes } from './app.routing';

// other
import { environment } from '../environments/environment';

@NgModule({
    declarations: [
        AppComponent,
    ],
    imports: [
        BrowserModule,
        CommonModule,
        HttpClientModule,
        NgxSpinnerModule,
        RouterModule.forRoot(routes, {useHash: false}),
        AggregatedLogTableModule,
    ],
    providers: [
        Location, {provide: LocationStrategy, useClass: PathLocationStrategy},
        {provide: HTTP_INTERCEPTORS, useClass: HttpApiInterceptor, multi: true},
        {provide: 'API_URL', useValue: environment.apiUrl}
    ],
    bootstrap: [AppComponent]
})
export class AppModule { }
