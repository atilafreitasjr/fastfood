<div>
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>
    <button wire:click="decrement">-</button>
    <button wire:click="increment(5)">+5</button>
    <button wire:click="decrement(5)">-5</button>
    <button wire:click="increment(10)">+10</button>
    <button wire:click="decrement(10)">-10</button>
    <button wire:click="zerar">Zerar</button>
</div>
