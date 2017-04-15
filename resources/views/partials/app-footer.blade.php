<footer class="app-footer">
    <div class="site-footer-right">
        @if (rand(1,100) == 100)
            <i class="softbd-rum-1"></i> Made with rum and even more rum
        @else
            Made with <i class="softbd-heart"></i> by <a href="http://thecontrolgroup.com" target="_blank">The Control Group</a>
        @endif
        @php $version = Softbd::getVersion(); @endphp
        @if (!empty($version))
            - {{ $version }}
        @endif
    </div>
</footer>
