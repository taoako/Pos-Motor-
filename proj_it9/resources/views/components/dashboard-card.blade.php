<!-- filepath: resources/views/components/dashboard-card.blade.php -->
@props(['title', 'value', 'color' => 'cyan'])

<div class="bg-gradient-to-br from-{{ $color }}-800 to-{{ $color }}-600 p-6 rounded-2xl shadow-lg transform hover:scale-105 transition duration-300">
    <h3 class="text-xl font-semibold tracking-wide">{{ $title }}</h3>
    <p class="text-3xl font-bold mt-2">{{ $value }}</p>
</div>