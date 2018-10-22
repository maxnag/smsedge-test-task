import { Routes } from '@angular/router';
import {AggregatedLogTableComponent} from "./modules/aggregated-log/aggregated-log-table/aggregated-log-table.component";

export const routes: Routes = [
    // authentication
    { path: '', redirectTo: '/', pathMatch: 'full'},
    { path: '**', component: AggregatedLogTableComponent }
];
