@php
    $segments = \Illuminate\Support\Facades\Request::segments();
@endphp
<div class="section-header">
{{--    <h1>{{ (isset($segments[1])) ? ucfirst($segments[1]).' - '.ucfirst($segments[2]) : 'Dashboard' }}</h1>--}}
   <span style="text-transform:uppercase"> <h1>{{ (isset($segments[1]) ? ucfirst(str_replace('-',' ',$segments[1])) : 'Dashboard') . (isset($segments[2]) ? ' '.ucfirst(str_replace('-',' ',$segments[2])) : '') }}</h1></span>
    <div class="section-header-breadcrumb">
{{--        <div class="breadcrumb-item active"><a href="{{ url('/') }}">Dashboard</a></div>--}}
        @foreach($segments as $segment)
            <div class="breadcrumb-item active">{{ ucfirst($segment) }}</div>
        @endforeach
    </div>
</div>
