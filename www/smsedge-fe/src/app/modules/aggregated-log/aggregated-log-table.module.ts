import { NgModule} from '@angular/core';
import { CommonModule } from '@angular/common';
import { NgxSpinnerModule } from 'ngx-spinner';

// bootstrap CSS
import { AlertModule } from 'ngx-bootstrap/alert';

// components
import { AggregatedLogTableComponent } from './aggregated-log-table/aggregated-log-table.component';

@NgModule({
    declarations: [
        AggregatedLogTableComponent,
    ],
    imports: [
        CommonModule,
        NgxSpinnerModule,

        // bootstrap CSS
        AlertModule.forRoot(),
    ],
    exports: [

    ]
})

export class AggregatedLogTableModule { }
