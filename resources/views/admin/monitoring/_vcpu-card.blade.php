{{--
  Partial: vCPU card
  Props: $vcpu (array), $wide (bool)
--}}
@php
    $statusColor = $vcpu['status'] === 'online' ? 'success' : 'danger';
    $statusLabel = $vcpu['status'] === 'online' ? 'Online' : 'Offline';
@endphp
<div class="card border-{{ $vcpu['color'] }} border-2 h-100 shadow-sm"
     style="{{ $wide ? 'max-width:400px;margin:0 auto' : '' }}">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded bg-{{ $vcpu['color'] }} bg-opacity-10 p-2">
                    <i class="bi {{ $vcpu['icon'] }} text-{{ $vcpu['color'] }} fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold text-{{ $vcpu['color'] }} small">{{ $vcpu['label'] }}</div>
                    <div class="fw-semibold" style="font-size:.85rem">{{ $vcpu['name'] }}</div>
                </div>
            </div>
            <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} border border-{{ $statusColor }}-subtle">
                <i class="bi bi-circle-fill me-1" style="font-size:.4rem"></i>{{ $statusLabel }}
            </span>
        </div>
        <p class="text-muted mb-2" style="font-size:.78rem">{{ $vcpu['desc'] }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Metrik</small>
            <span class="badge bg-{{ $vcpu['color'] }}-subtle text-{{ $vcpu['color'] }} border border-{{ $vcpu['color'] }}-subtle">
                {{ $vcpu['metric'] }}
            </span>
        </div>
    </div>
</div>
