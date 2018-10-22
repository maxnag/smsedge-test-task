import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AggregatedLogTableComponent } from './aggregated-log-table.component';

describe('AggregatedLogTableComponent', () => {
  let component: AggregatedLogTableComponent;
  let fixture: ComponentFixture<AggregatedLogTableComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AggregatedLogTableComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AggregatedLogTableComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
