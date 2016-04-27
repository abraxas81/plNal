@extends('log-viewer::_template.master-edited')

@section('breadcrumbs')
    {!! Breadcrumbs::render('log-viewer::dashboard') !!}


    @section('filters')
        <form id="admin_tariffs_internet_filter">
            <div class="splynx-nav-right">
                <a href="{{ route('log-viewer::logs.list') }}">
                    <i class="fa fa-archive"></i> Pregledaj
                </a>
            </div>
        </form>
    @endsection
@endsection


@section('demo')
    <div class="row">
        <div class="col-md-3">
            <canvas id="stats-doughnut-chart"></canvas>
        </div>
        <div class="col-md-9">
            <section class="box-body">
                <div class="row">
                    @foreach($percents as $level => $item)
                        <div class="col-md-4">
                            <div class="info-box level level-{{ $level }} {{ $item['count'] === 0 ? 'level-empty' : '' }}">
                                <span class="info-box-icon">
                                    {!! log_styler()->icon($level) !!}
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ $item['name'] }}</span>
                                    <span class="info-box-number">
                                        {{ $item['count'] }} unosa- {!! $item['percent'] !!} %
                                    </span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ $item['percent'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            var data = {!! $reports !!};

            new Chart($('#stats-doughnut-chart')[0].getContext('2d'))
                .Doughnut(data, {
                    animationEasing : "easeOutQuart"
                });
        });
    </script>
@endsection