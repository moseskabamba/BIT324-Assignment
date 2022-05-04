@props(['footer' => ''])
<div class="overflow-x-scroll shadow md:overflow-x-visible md:min-w-full md:inline-block">
    <table class="w-full">
        <thead>
            {{ $head }}
        </thead>
        <tbody>
            {{ $body }}
        </tbody>
    </table>
</div>
