@extends('layouts.web')

@push('styles')

@endpush

@section('content')
    <div class=" @if(\Helper::getCustomLayout()['expanded_layout']) container-fluid @else container @endif">
        <h1>Lista de Notificações</h1>

        @if(count($notifications) > 0)
            <div class="mb-5">
                @foreach($notifications as $notification)
                    <div class="notification" role="alert">
                        <div class="notification-icon">
                            <i class="fa-regular fa-bell bi flex-shrink-0 text-3xl" style="font-size: 2rem;margin-right: 10px !important;"></i>
                        </div>
                        <div class="notification-body">
                            {{ $notification->data['message'] }}
                        </div>
                        <div class="notification-time">
                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans(); }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $notifications->links() }}
        @else
            <div class="mb-5 w-full" style="display: flex; justify-content: center;">
                <div class="text-center">
                    <img src="{{ asset('/assets/images/empty_data_icon_149938.png') }}" alt="">
                    <h1>Sem registros</h1>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')

@endpush
