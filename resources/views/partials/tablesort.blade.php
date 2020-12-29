@if ($sortField == $field && $sortDirection == 'asc')
    <i wire:click="sort('{{ $field }}', 'desc')" class="fa fa-sort-asc" aria-hidden="true"></i>
@elseif ($sortField == $field && $sortDirection == 'desc')
    <i wire:click="sort('{{ $field }}', 'asc')" class="fa fa-sort-desc" aria-hidden="true"></i>
@else
    <i wire:click="sort('{{ $field }}', 'asc')" class="fa fa-sort" aria-hidden="true" style="opacity: 0.4"></i>
@endif
