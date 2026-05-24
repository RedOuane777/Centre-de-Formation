@extends('layouts.app')
@section('content')
<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Emploi du Temps
</h1>

<style>
    .emploi-table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        font-size: 14px;
    }

    .emploi-table th {
        background-color: #1844ba;
        color: #fff;
        font-weight: normal;
        padding: 8px 4px;
        text-align: center;
        border: 1px solid #1844ba;
    }

    .emploi-table td {
        border: 1px solid #dee2e6;
        padding: 0;
        height: 54px;
        vertical-align: bottom;
        text-align: center;
        background-color: #fff;
    }

    .time-cell {
        height: 54px;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding-bottom: 3px;
        font-size: 13px;
        color: #6c757d;
    }

    .seance-td {
        background-color: #d1ecf1 !important;
        vertical-align: middle !important;
    }

    .seance-cell {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
        text-align: center;
        line-height: 1.3;
        padding: 4px 2px;
        overflow: hidden;
    }

    .seance-cell strong {
        font-size: 13px;
        color: #0c5460;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
    }

    .seance-cell small {
        font-size: 11px;
        color: #155724;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
    }

    .time-header {
        background-color: #f8f9fa !important;
        color: #6c757d !important;
        border: 1px solid #dee2e6 !important;
        font-weight: 500;
    }

    .examen-td {
        background-color: #fb8c97 !important;
        overflow: visible !important;
    }

    .examen-td .seance-cell strong,
    .examen-td .seance-cell small {
        white-space: normal;
        overflow: visible;
        text-overflow: unset;
    }

    .examen-td .seance-cell {
        overflow: visible !important;
    }
</style>

@php
use Carbon\Carbon;
$jours = [
    1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi',
    4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi'
];
$firstSlot = '08:30';
$startTime = Carbon::createFromTime(9, 30);
$endTime = Carbon::createFromTime(18, 30);
$timeSlots = [];
$time = $startTime->copy();
while ($time <= $endTime) {
    $timeSlots[] = $time->format('H:i');
    $time->addHour();
}

function getRowSpan($start, $end) {
    $startC = Carbon::createFromFormat('H:i', substr($start, 0, 5));
    $endC   = Carbon::createFromFormat('H:i', substr($end,   0, 5));
    return max(1, (int) round($startC->diffInMinutes($endC) / 60));
}
@endphp

@php $skip = []; @endphp

<div class="table-responsive shadow-sm rounded mb-5">
    <table class="emploi-table">
        <colgroup>
            <col style="width: 65px;">
            @foreach($jours as $j)
                <col>
            @endforeach
        </colgroup>
        <thead>
            <tr>
                <th class="time-header">{{ $firstSlot }}</th>
                @foreach($jours as $jour)
                    <th>{{ $jour }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($timeSlots as $slot)
                <tr>
                    <td style="padding:0; vertical-align:bottom; background-color:#f8f9fa;">
                        <div class="time-cell">{{ $slot }}</div>
                    </td>

                    @foreach($jours as $numJour => $jour)
                        @php
                        if (isset($skip[$numJour][$slot])) continue;
                        $slotTime = Carbon::createFromFormat('H:i', $slot);
                        $event = null;

                        foreach ($events as $e) {
                            $date = $e->date ?? $e->dateE;
                            $eventDayNum = (int) Carbon::parse($date)->dayOfWeekIso;

                            if (
                                $eventDayNum == $numJour &&
                                $slotTime->copy()->subHour()->format('H:i') == substr($e->heure_debut, 0, 5)
                            ) {
                                $event = $e;
                                break;
                            }
                        }
                        @endphp

                        @if($event)
                            @php
                            $span = getRowSpan($event->heure_debut, $event->heure_fin);
                            for ($i = 1; $i < $span; $i++) {
                                $skip[$numJour][Carbon::createFromFormat('H:i', $slot)->addMinutes(60 * $i)->format('H:i')] = true;
                            }
                            @endphp
                            <td class="seance-td {{ $event->type === 'examen' ? 'examen-td' : '' }}" rowspan="{{ $span }}">
                                <div class="seance-cell">
                                    <strong>{{ $event->moduleGroupeEnseignant->module->titre }}</strong>
                                    <small>{{ $event->moduleGroupeEnseignant->groupe->libelle }}</small>
                                    <small>Salle: {{ $event->salle }}</small>
                                    @if($event->type === 'examen')
                                        <strong>{{ $event->typeE }}</strong>
                                    @endif
                                </div>
                            </td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection